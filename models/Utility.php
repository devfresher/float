<?php
// require VENDOR_DIR.'autoload.php';
// use Dompdf\Dompdf;

class Utility extends Database {

    protected $responseBody;

    function __construct($db) {
        $this->db = $db;
        $this->responseBody	= array();
    }

    /**
     * convert ojects to array
     *
     * @param array $array
     * @return object
     */
    public function arrayToObject($array)
    {
        return (object) $array;

    }

    /**
     * convert arrays to object
     *
     * @param object $object
     * @return array
     */
    public function objectToArray($object)
    {
	    return (array) $object;

    }

    public function randID($length = 5, $character) { 
        $alphabets = 'aeioubcdfghjklmnpqrstvwxyz'; 
        $numbers = '0123456789'; 

        $idnumber = '';
        switch ($character) {
            case 'numeric':
            case 'num':
                for ($i = 0; $i < $length; $i++) { 
                    $idnumber.= substr($numbers, (rand()%(strlen($numbers))), 1);
                } 
                break;

            case 'alphabetic':
            case 'alpha':
                for ($i = 0; $i < $length; $i++) { 
                    $idnumber.= substr($alphabets, (rand()%(strlen($alphabets))), 1);
                } 
                break;
        }

         
        return $idnumber; 
    } 
    
    public function niceDateFormat($date, $format="date_time") {

        if ($format == "date_time") {
            $format = "D j, M Y h:ia"; 
        } else {
            $format = "D j, M Y";
        }

        $timestamp = strtotime($date);
        $niceFormat = date($format, $timestamp);

        return $niceFormat;
    }

    public function displayFormError()
    {
        $formError = "";
        if (isset($_SESSION['formErrorMessage'])) {
            $formError .= '<div class="alert alert-alt left-icon-big alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="media">
                    <div class="alert-left-icon-big">
                        <span class="">
                            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                        </span>
                    </div>

                    <div class="media-body">';
                        if (is_array($_SESSION['formErrorMessage'])) {
                            $formError .= '<h5 class="mt-1 mb-2">Errors!</h5>';
                            foreach ($_SESSION['formErrorMessage'] as $key => $error) {
                                $formError .= '<li>' .$error. '</li>';
                            }
                        } else { 
                            $formError .= '<strong>Error:</strong> ' .$_SESSION['formErrorMessage'];
                        }
                    $formError .= '</div> 
                </div>
            </div>';

            unset($_SESSION['formErrorMessage']);
            return $formError;
        }
    }

    public function displayFormSuccess()
    {
        $formSuccess = "";
        if (isset($_SESSION['formSuccessMessage'])) {
            $formSuccess .= '<div class="alert alert-alt alert-success alert-dismissible fade show" role="alert">
                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>';
                if (is_array($_SESSION['formSuccessMessage'])) {
                    $formSuccess .= "<h3>Success!</h3><ul>";
                    foreach ($_SESSION['formSuccessMessage'] as $key => $msg) {
                        $formSuccess .= '<li>' .$msg. '</li>';
                    }
                    $formSuccess .= "</ul>";
                } else { 
                    $formSuccess .= $_SESSION['formSuccessMessage'];
                }

                $formSuccess .= '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>';

            unset($_SESSION['formSuccessMessage']);
            return $formSuccess;
        }
    }

    public function returnFormInput($name)
    {
        $formInput = '';
        if (isset($_SESSION['formInput'][$name])) {
            $formInput = $_SESSION['formInput'][$name];
            unset($_SESSION['formInput'][$name]);
        }

        echo $formInput;
    }

    public function returnSelectInput($name, $optionValue)
    {
        $selected = '';
        if (isset($_SESSION['formInput'][$name])) {
            $formInput = $_SESSION['formInput'][$name];

            if ($formInput == $optionValue) {
                unset($_SESSION['formInput'][$name]);
                $selected = 'selected';
            }

        }

        echo $selected;
    }

    public function returnSelectInputFromDB($value, $dbArray)
    {
        $selected = '';

        if (is_array($dbArray) AND in_array($value, $dbArray)) {
            $selected = 'selected';
        }

        echo $selected;
    }

    public function showAuthorizeForm($pageSlug)
    {
        $auth = new Authorization($this->db);
        $app = new App($this->db);

        $formErrors = $this->displayFormError();
        $pageInfo = $auth->getPage(PAGE_NAME);

        include COMPONENT_DIR.'authorizationForm.php';
        die;
    }

    public function downloadHTMLToPDF($html, $filePath)
    {
        // instantiate and use the dompdf class
        $dompdf = new Dompdf();
        
        $dompdf->loadHtml($html);
        
        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait');
        // $dompdf->setPaper('A4', 'landscape');
        
        // Render the HTML as PDF
        $dompdf->render();

        $output = $dompdf->output();
        // print_r(UPLOADS_PATH.$filePath);die;
        file_put_contents(UPLOADS_PATH.$filePath, $output);

        return $filePath;
    }

    public function redirectToLandingPage()
    {
        global $allSettings;

        $landingPage = $allSettings->landingPage;
        $url = BASE_URL.$landingPage;

        header('Location: '.$url);
        exit;
    }

    public function getFileSize($url)
    {
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, TRUE);
        curl_setopt($ch, CURLOPT_NOBODY, TRUE);

        $data = curl_exec($ch);
        $size = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);

        curl_close($ch);
        echo $size;
    }
}

?>