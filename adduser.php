<?php
$url = "portal.yoffice.ru";
$login = "site";
$password = "kmn1494q";
$ns_customer = "https://".$url."/Porta/SOAP/Customer";
$ns_user = "https://".$url."/Porta/SOAP/User";
include ('structure.php');

$session_service  = new SoapClient("https://$url/wsdl/SessionAdminService.wsdl");
$customer_service = new SoapClient("https://$url/wsdl/CustomerAdminService.wsdl");
$accout_service   = new SoapClient("https://$url/wsdl/AccountAdminService.wsdl");
$user_service   = new SoapClient("https://$url/wsdl/UserAdminService.wsdl");

$session_id = $session_service->login($login, $password);

echo "Logged in with session $session_id\n";

$auth_header = "<auth_info><session_id>$session_id</session_id></auth_info>";
$objVar_Session_Inside = new SoapVar($auth_header, XSD_ANYXML, null, null, null);
//print_r($objVar_Session_Inside);
$customer_header = new SoapHeader($ns_customer, 'auth_info', $objVar_Session_Inside);
$customer_service->__setSoapHeaders(array($customer_header));

$user_header = new SoapHeader($ns_user, 'auth_info', $objVar_Session_Inside);
$user_service->__setSoapHeaders(array($user_header));



//print ($user_service->get_user_list())
$r = array ("name" => 'test 1');
$CustomerInfoRequest->customer_info = new  TCustomerInfo();

//$CustomerInfoRequest->customer_info = array ("name"=> $r->name);
//$CustomerInfoRequest = array ("i_customer" => 'Super_Test',"companyname" => 'Super Company');
//$customer_info = array ( "customer_info"->name  => array( "name"     => 'NEW_CUSTOMER_NAME',),);

//$CustomerInfoResponse = $customer_service->get_customer_info($customer_header, $CustomerInfoRequest);
$CustomerInfoResponse = $customer_service->get_customer_info($customer_header, $CustomerInfoRequest);
print_r ($CustomerInfoResponse);
//print_r ($CustomerInfoRequest);
//if (isset($CustomerInfoResponse) && )
//$request  = array ("customer_info" => $CustomerInfoRequest);

//$AddCustomerResponse = $customer_service->add_customer($customer_header, $CustomerInfoRequest);

//if ! ($GetCustomerInfoResponse->customer_info)  echo "No customer found\n";
//$UserInfoListRequest = array ("offset" => 0, "limit" => 5 , "search" => "_");
//$UserListResponse = $user_service->get_user_list($user_header,$UserInfoListRequest);

//$user->__soapCall('get_user_list',  null);

$result = $session_service->logout($session_id);
if (empty ($result)) echo "Logout success\n";
?>