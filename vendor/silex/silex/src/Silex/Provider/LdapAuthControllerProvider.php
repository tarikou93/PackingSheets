<?php
namespace Silex\Provider;
use Silex\Application;
use Silex\Api\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Zend\Ldap\Exception\LdapException;
class LdapAuthControllerProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        // creates a new controller based on the default route
        $controllers = $app['controllers_factory'];
        //use session storage
        $app->register(new \Silex\Provider\SessionServiceProvider());
        //register ldap service
        $app['auth.ldap'] = function() use ($app) {
            return new \Zend\Ldap\Ldap($app['auth.ldap.options']);
        };
        //redirect to login page if not logged in
        $app->before(
            function (Request $request) use ($app) {
                //user is not logged in go to login
                if (null === $app['session']->get('user') && $request->get("_route") !== 'login' && $request->get("_route") !== '_auth_keepalive') {
                    $app['session']->set('user_target', $request->getUri());
                    return $app->redirect('/auth/login');
                }
                //user is logged in - go to home
                if ($app['session']->get('user') && $request->get("_route") == 'login') {
                    return $app->redirect('/');
                }
                //write close to allow concurrent requests
                $app['session.storage']->save();
            }
        );
        $controllers->match(
            '/login',
            function (Request $request) use ($app) {
                $view_params = array('error'=>null);
                //handle login where appropriate
                if ($request->get('user') && $request->get('password')) {
                    try {
                        //throws exception
                        //return var_dump($app['auth.ldap']);
                        $ldap = $app['auth.ldap'];
                        $ldap->bind($request->get('user'), $request->get('password'));
                        //$app['session']->set('user', array('username' => $request->get('user')));
                                                
                        $acctname = $ldap->getCanonicalAccountName($request->get('user'),\Zend\Ldap\Ldap::ACCTNAME_FORM_DN);
                        $hm = $ldap->getEntry($acctname);
                        
                        $firstName = $hm['givenname'];
                        $name = $hm['sn'];
                        
                        $app['session']->set('user', array('username' => $request->get('user'), 'firstName' => $firstName, 'name' => $name));
                        
                        $groups = $hm['memberof'];
                        
                        if(in_array('CN=BRUAPPPackingSheet_Admin,OU=PackingSheet,OU=Apps,OU=Groups,OU=BRU,DC=company,DC=corp', $groups)){
                            $acredLevel = 3;
                            $packingSheetsSeries = array('1' => 1, '2' => 2);
                        }
                        elseif(in_array('CN=BRUAPPPackingSheet_SuperUser,OU=PackingSheet,OU=Apps,OU=Groups,OU=BRU,DC=company,DC=corp', $groups)){
                            $acredLevel = 2;
                            $packingSheetsSeries = array('1' => 1, '2' => 2);
                        }
                        else{
                            if(in_array('CN=BRUAPPPackingSheet_User_G1,OU=PackingSheet,OU=Apps,OU=Groups,OU=BRU,DC=company,DC=corp', $groups)){
                                $packingSheetsSeries = array('1' => 1);
                                $acredLevel = 1;
                            }
                            elseif(in_array('CN=BRUAPPPackingSheet_User_G2,OU=PackingSheet,OU=Apps,OU=Groups,OU=BRU,DC=company,DC=corp', $groups)){
                                $packingSheetsSeries = array('2' => 2);
                                $acredLevel = 1;
                            }
                            else {
                                $app['session']->set('user', null);
                                $app['session']->getFlashBag()->add('login_error', 'Unaccredited user - Contact IT Support to access PackingSheets');
                                return $app->redirect('/');
                            }
                        }
                        
                        //$isAdmin = in_array('CN=BRUAPPCTXDevis,OU=Apps,OU=Groups,OU=BRU,DC=company,DC=corp', $groups);
                        /*CN=BRUAPPPackingSheet_Admin,OU=PackingSheet,OU=Apps,OU=Groups,OU=BRU,DC=company,DC=corp
                        CN=BRUAPPPackingSheet_SuperUser,OU=PackingSheet,OU=Apps,OU=Groups,OU=BRU,DC=company,DC=corp
                        CN=BRUAPPPackingSheet_User_G1,OU=PackingSheet,OU=Apps,OU=Groups,OU=BRU,DC=company,DC=corp
                        CN=BRUAPPPackingSheet_User_G2,OU=PackingSheet,OU=Apps,OU=Groups,OU=BRU,DC=company,DC=corp*/


                        $app['session']->set('auth', array('acredLevel' => $acredLevel, 'packingSheetsSeries' => $packingSheetsSeries));

                        if ($user_target = $app['session']->get('user_target')) {
                            return $app->redirect($user_target);
                        } else {
                            return $app->redirect('/');
                        }
                    } catch (LdapException $e) {
                        //$view_params['error'] = 'Login Failed with error code '.$e->getcode();
                        $strError = substr($e->getMessage(), 0, strpos($e->getMessage(), ';'));
                        $app['session']->getFlashBag()->add('login_error', 'Login Failed (error code '.$e->getcode().') - '.$strError.')');
                    }
                }
                return $app['twig']->render($app['auth.template.login'], $view_params);
                //return $app['twig']->render('test.html.twig');
            }
        )->bind('login');
        $controllers->match(
            '/logout',
            function (Request $request) use ($app) {
                $app['session']->set('user', null);
                return $app->redirect('/');
            }
        );
        $controllers->match(
            '/keepalive',
            function() use ($app) {
                if ($app['session']->get('user')) {
                    return new Response('', 204);
                }
                return new Response('Expired', 403);
            }
        );
        return $controllers;
    }
}
