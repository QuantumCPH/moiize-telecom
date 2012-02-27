<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<html>
    <head>
        <title>Zapna</title>
    </head>
    <body>
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
            <table width="100%">
                <thead>
                    <th>Hardware</th>
                    <th>Abonnement</th>
                    <th>Bindingsperiode</th>
                    <th>Tillæg Antal</th>
                    <th>Pris.pr.stk*</th>
                </thead>
                <tbody>
               total_price = 0;
               foreach($company->getProductDetails() as $product){
                    <tr>
                        <td>Zapna Smart card</td>
                        <td>Zapna World</td>
                        <td>0 måneder</td>
                        <td>'.$product->getSimCardQuantity().'</td>
                        <td>'.$product->getPricePerSim().'</td>
                    </tr>
               }
                </tbody>
                <tfoot>
                    <tr>
                        <td> * Være opmærksom på, at alle priser er eksklusive moms og gælder kun for CVR-registrerede virksomheder</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div id="accept-subscription" style="padding: 10px; margin: 10px; border-bottom:1px #ff6600 dashed; width:100%;">
            <h2>Accept af tilmelding</h2>
            Jeg håber, at ovenstående svarer til dine forventninger. Såfremt du har spørgsmål eller ønsker yderligere information, er du meget velkommen til a kontakte mig.
            <br/>
            <br/>
            <a style="font-size:18px;font-weight:bold" href="link-to-confirmation-page?some-unique-id&company_id="> &gt;&gt; Accepter tilmelding</a>
            &nbsp; | &nbsp;
            <a style="font-size:15px;font-weight:bold" href="link-to-rejection-page?some-unique-id&company_id="> &gt;&gt; Afvis tilmelding</a>
            <br/>
            <br/>
            Husk at læse vedhæftede kontrakt og vilkår. I tilfælde af uoverensstemmelse mellem disse og ovenstående, er det altid kontrakt og vilkår, der er gældende.
        </div>
    </body>
</html>