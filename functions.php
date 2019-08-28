
// If URI is correct URI, make request, else return all other functions from functions.php
function wpdev_before_after($content) {
    if(is_page('mailchimp-api-exec')){
        $beforecontent = 'mailchimp_batch_request';
        $fullcontent = $beforecontent() . $content;
    } else {
        $fullcontent = $content;
    }
    
    return $fullcontent;
}
add_filter('the_content', 'wpdev_before_after');

function mailchimp_batch_request() {

    //check client-side request type
    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        $api_key = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxx';
            
	// store list id and template id in variables 
        $list_id_1 = 'g32c478394';
        $template_id_1 = 980293;
            
        $list_id_2 = '01c9938485';
        $template_id_2 = 192838;

        // Mailchimp API 3.0 batch call
        $url = 'https://us16.api.mailchimp.com/3.0/batches/';
        
        // body data
        // formatting is based on Mailchimp's API spec for batch calls
        // format body data for batch campaign generation. See Mailchimp API docs.

        $body_data_1 = "{ 
                                \"type\": \"regular\",
                                \"recipients\": {
                                    \"list_id\": \""
                            . $list_id_1. "\"
                                },
                                \"settings\": {
                                    \"subject_line\": \"Check out our monthly newsletter\",
                                    \"template_id\": 
                            994567
                            ,
                                    \"from_name\": \"*|CONTACT|*\",
                                    \"reply_to\": \"*|POC|*@yourcompany.com\",
                                    \"title\": \"
                            Our Monthly News Letter
                            \"
                                }
                            }";

                $body_data_2= "{ 
                                \"type\": \"regular\",
                                \"recipients\": {
                                    \"list_id\": \""
                            . $list_id_2 . "\"
                                },
                                \"settings\": {
                                    \"subject_line\": \"Check out our new product\",
                                    \"template_id\": 
                            997654
                            ,
                                    \"from_name\": \"*|CONTACT|*\",
                                    \"reply_to\": \"*|POC|*@yourcompany.com\",
                                    \"title\": \"
                            Our New Feature News Letter
                            \"
                                }
                            }";
           

        $replace_lines_1 = str_replace("\n", "", $body_data_1);
        $replace_lines_2 = str_replace("\n", "", $body_data_2);

             

        $data = array(
            "operations"    => array(
                        array(
                            "method" => "POST",
                            "path"   => "/campaigns",
                            "operation_id" => "02335435op1",
                            "body" => $replace_lines_1 

                            ),

                        array(
                            "method" => "POST",
                            "path"   => "/campaigns",
                            "operation_id" => "02362735op2",
                            "body" =>  $replace_lines_2

                            )
                     )

        );



        // // Encode the data
        $encoded_data = json_encode($data);
        echo $encoded_data;

        // // // Setup cURL sequence
        $ch = curl_init();


        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $api_key);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encoded_data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $results = curl_exec($ch);
        $response = curl_getinfo($ch, CURLINFO_HTTP_CODE); 
        $errors = curl_error($ch); 
        curl_close($ch);

        var_dump($results);
        echo json_encode($response);
    }
}
