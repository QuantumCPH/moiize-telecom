<?php

sfLoader::loadHelpers(array('Url'));

class mail_messages{
	
	public static $REGISTRATION_SUBJECT = "Registration email";
	public static function html_registration_mail($company, $code){
		
		
		$message = '<html>
                                <head>
                                    <title>Zapna</title>
                                </head>
                                <body style="color:#ff6600">
                                    <div id="container" style="width:80%;">
                                        <div id="header" style="padding: 10px; margin: 10px; border-bottom:1px #ff6600 dashed; width:100%">
                                            <h1>Tilmelding til Zapna</h1>
                                        </div>
                                        <div id="greeting" style="padding: 10px; margin: 10px; border-bottom:1px #ff6600 dashed; width:100%">
                                            <h2>Kære '.$company->getContactName().'</h2>
                                            Tak, for jeres tilmelding til Zapna. Hermed fremsendes en oversigt over jeres tilmelding.
                                        </div>
                                        <div id="company-info" style="padding: 10px; margin: 10px; width:100%">
                                            <h2>Nærværende tilbud er gælder for:</h2>
                                            '.$company->getName().'<br/>
                                            '.$company->getCvrNumber().'<br/>
                                            '.$company->getAddress().'<br/>
                                            '.$company->getPostCode().' - '.$company->getCity().'<br/>
                                        </div>
                                        <div id="product-detail" style="padding: 10px; margin: 10px; border-bottom:1px #ff6600 dashed; width:100%;">
                                            <h2>Produkter og priser</h2>
                                            <table width="100%" style="text-align:center; border:1px solid">
                                                <thead>
                                                    <th>Hardware</th>
                                                    <th>Abonnement</th>
                                                    <th>Bindingsperiode</th>
                                                    <th>Tillæg Antal</th>
                                                    <th>Pris.pr.stk*</th>
                                                </thead>
                                                <tbody>';

                                               foreach($company->getProductOrders() as $product){
                                                    $message = $message . '<tr>
                                                                    <td>Zapna Smart card</td>
                                                                    <td>Zapna World</td>
                                                                    <td>0 måneder</td>
                                                                    <td>'.$product->getSimCardQuantity().'</td>
                                                                    <td>'.$product->getPricePerSim().'</td>
                                                                </tr>';
                                               }

                                               $message = $message .'</tbody>

                                            </table>
                                            <span style="margin-top:20px;font-size:11px">* Være opmærksom på, at alle priser er eksklusive moms og gælder kun for CVR-registrerede virksomheder</span>
                                        </div>

                                        <div id="accept-subscription" style="padding: 10px; margin: 10px; border-bottom:1px #ff6600 dashed; width:100%;">
                                            <h2>Accept af tilmelding</h2>
                                            Jeg håber, at ovenstående svarer til dine forventninger. Såfremt du har spørgsmål eller ønsker yderligere information, er du meget velkommen til a kontakte mig.
                                            <br/>
                                            <br/>
                                            <a style="font-size:18px;font-weight:bold" href="'.url_for('company/activation?code='.$code, true).'"> &gt;&gt; Accepter tilmelding</a>
                                            &nbsp; | &nbsp;
                                            <a style="font-size:15px;font-weight:bold" href="'.url_for('company/rejection?code='.$code, true).'"> &gt;&gt; Afvis tilmelding</a>
                                            <br/>
                                            <br/>
                                            Husk at læse vedhæftede kontrakt og vilkår. I tilfælde af uoverensstemmelse mellem disse og ovenstående, er det altid kontrakt og vilkår, der er gældende.
                                        </div>
                                     </div>
                                </body>
                            </html>';
		
		return $message;
        }
}
?>