
<script type='text/javascript'>

	function changePrice() {
		index = document.getElementById('ratelist').selectedIndex;
		val = document.getElementById('text_'+index).value;
		val2 = document.getElementById('text2_'+index).value;
		document.getElementById('lable').innerHTML=val;
		document.getElementById('lable2').innerHTML=val2;
		var price1 = document.getElementById('price1');
		var price2 = document.getElementById('price2');

		if(index == 0) {
			price1.style.display = 'none';
			price2.style.display = 'none';
		} else {
			price1.style.display = 'block';
			price2.style.display = 'block';
		}
		Cufon.replace('#price-calculator ul li.price', { fontFamily: 'Barmeno-Medium', hover:true });
	}
function allfunc(){
	changePrice();

}

</script>
<script language="javascript">
		jQuery(document).ready(function(){
		jQuery('#nav2>li.current_page_item ul, #nav2>li.current_page_ancestor ul').css('display','block');
		jQuery('#nav2>li').hover(function(){
			jQuery('#nav2 li ul').css('display','none');
			jQuery(this).children('ul').css('display','block');
		});

		jQuery('#nav2').mouseout(function(){
			setTimeout( function(){
				jQuery('#nav2 li ul').fadeOut('fast')
				}, 20000 );
		});
	});
</script>


<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<table>
    <tr>
    <td style="padding-left:25px;font-color:#ff00ff;font-size:18px;">
     Vores priser: <br/>
    </td>
    </tr>
    <tr>
        <td style="padding-left:55px;">
 <select id='ratelist' name='ratelist' onchange='changePrice();'>
						<option >AFGHANISTAN </option><br />
						<option >ALBANIEN </option><br />
						<option >ALGERIET </option><br />

						<option >ANDORRA </option><br />
						<option >ANGOLA </option><br />
						<option >ANTIGUA OG BARBUDA </option><br />
						<option >ANTILLES-NEDERLANDENE </option><br />
						<option >ARGENTINA </option><br />
						<option >ARMENIEN </option><br />

						<option >ARUBA </option><br />
						<option >AUSTRALIEN </option><br />
						<option >ASERBAJDSJAN </option><br />
						<option >Bahrain </option><br />
						<option >BANGLADESH </option><br />
						<option >BARBADOS </option><br />

						<option >BELARUS </option><br />
						<option >BELGIEN </option><br />
						<option >BELIZE </option><br />
						<option >BENIN </option><br />
						<option >Bhutan </option><br />
						<option >BOLIVIA </option><br />

						<option >BOSNIEN </option><br />
						<option >BOTSWANA </option><br />
						<option >BRASILIEN </option><br />
						<option >BRUNEI </option><br />
						<option >BULGARIEN </option><br />
						<option >BURKINA FASO </option><br />

						<option >BURUNDI </option><br />
						<option >CAMBODJA </option><br />
						<option >CAMEROUN </option><br />
						<option >CANADA </option><br />
						<option >KAP VERDE </option><br />
						<option >CAYMANØERNE </option><br />

						<option >CENTRALAFRIKANSKE REPUBLIK </option><br />
						<option >TCHAD </option><br />
						<option >CHILE </option><br />
						<option >KINA </option><br />
						<option >COLOMBIA </option><br />
						<option >COSTA RICA </option><br />

						<option >KROATIEN </option><br />
						<option >CYPERN </option><br />
						<option >TJEKKIET </option><br />
						<option >DEN DEMOKRATISKE REPUBLIK CONGO </option><br />
						<option >DJIBOUTI </option><br />
						<option >DOMINICA </option><br />

						<option >DOMINIKANSKE REPUBLIK </option><br />
						<option >ECUADOR </option><br />
						<option >EGYPTEN </option><br />
						<option >EL SALVADOR </option><br />
						<option >ESTLAND </option><br />
						<option >ETIOPIEN </option><br />

						<option >FÆRØERNE </option><br />
						<option >FIJI </option><br />
						<option >FINLAND </option><br />
						<option >FRANKRIG </option><br />
						<option >FRANSK GUYANA </option><br />
						<option >GABON </option><br />

						<option >GAMBIA </option><br />
						<option >GEORGIEN </option><br />
						<option >TYSKLAND </option><br />
						<option >GHANA </option><br />
						<option >GIBRALTAR </option><br />
						<option >GRÆKENLAND </option><br />

						<option >GRØNLAND </option><br />
						<option >GRENADA </option><br />
						<option >Guadeloupe </option><br />
						<option >GUATEMALA </option><br />
						<option >GUINEA BISSAU </option><br />
						<option >GUYANA </option><br />

						<option >HAITI </option><br />
						<option >HOLLAND </option><br />
						<option >HONDURAS </option><br />
						<option >HONG KONG </option><br />
						<option >UNGARN </option><br />
						<option >ISLAND </option><br />

						<option >INDIEN </option><br />
						<option >INDONESIEN </option><br />
						<option >IRAN </option><br />
						<option >IRAK </option><br />
						<option >IRLAND </option><br />
						<option >ISRAEL </option><br />

						<option >PALÆSTINA </option><br />
						<option >ITALIEN </option><br />
						<option >ELFENBENSKYSTEN </option><br />
						<option >JAMAICA </option><br />
						<option >JAPAN </option><br />
						<option >JORDAN </option><br />

						<option >KASAKHSTAN </option><br />
						<option >KENYA </option><br />
						<option >KIRIBATI </option><br />
						<option >KOREA SOUTH </option><br />
						<option >KUWAIT </option><br />
						<option >KIRGISISKE </option><br />

						<option >LAOS </option><br />
						<option >LETLAND </option><br />
						<option >LIBANON </option><br />
						<option >LESOTHO </option><br />
						<option >LIBERIA </option><br />
						<option >LIBYEN </option><br />

						<option >LIECHTENSTEIN </option><br />
						<option >LITAUEN </option><br />
						<option >LUXEMBOURG </option><br />
						<option >MACAO </option><br />
						<option >MAKEDONIEN </option><br />
						<option >MADAGASCAR </option><br />

						<option >MALAWI </option><br />
						<option >MALAYSIA </option><br />
						<option >MALDIVERNE </option><br />
						<option >MALI </option><br />
						<option >MALTA </option><br />
						<option >Martinique </option><br />

						<option >MAURETANIEN </option><br />
						<option >MAURITIUS </option><br />
						<option >MEXICO </option><br />
						<option >MOLDOVA </option><br />
						<option >MONACO </option><br />
						<option >MONGOLIET </option><br />

						<option >MAROKKO </option><br />
						<option >MOZAMBIQUE </option><br />
						<option >MYANMAR </option><br />
						<option >NAMIBIA </option><br />
						<option >NAURU </option><br />
						<option >NEPAL </option><br />

						<option >NY KALEDONIEN </option><br />
						<option >NEW ZEALAND </option><br />
						<option >NIGER </option><br />
						<option >NIGERIA </option><br />
						<option >NORGE </option><br />
						<option >OMAN </option><br />

						<option  selected>PAKISTAN </option><br />
						<option >PALAU </option><br />
						<option >PANAMA </option><br />
						<option >PARAGUAY </option><br />
						<option >PERU </option><br />
						<option >FILIPPINERNE </option><br />

						<option >POLEN </option><br />
						<option >PORTUGAL </option><br />
						<option >QATAR </option><br />
						<option >REUNION </option><br />
						<option >RUMÆNIEN </option><br />
						<option >RUSLAND </option><br />

						<option >RWANDA </option><br />
						<option >SAUDI-ARABIEN </option><br />
						<option >SENEGAL </option><br />
						<option >SERBIEN </option><br />
						<option >SEYCHELLERNE </option><br />
						<option >SIERRA LEONE </option><br />

						<option >SINGAPORE </option><br />
						<option >SLOVAKIET </option><br />
						<option >SLOVENIEN </option><br />
						<option >SOMALIA </option><br />
						<option >SOUTH AFRICA </option><br />
						<option >SPANIEN </option><br />

						<option >SRI LANKA </option><br />
						<option >ST LUCIA </option><br />
						<option >ST PIERRE </option><br />
						<option >ST VINCENT </option><br />
						<option >SUDAN </option><br />
						<option >SURINAME </option><br />

						<option >SWAZILAND </option><br />
						<option >SVERIGE </option><br />
						<option >SCHWEIZ </option><br />
						<option >SYRIEN </option><br />
						<option >TAIWAN </option><br />
						<option >TADSJIKISTAN </option><br />

						<option >TANZANIA </option><br />
						<option >THAILAND </option><br />
						<option >TOGO </option><br />
						<option >TONGA </option><br />
						<option >TRINIDAD and TOBAGO </option><br />
						<option >TUNESIEN </option><br />

						<option >TYRKIET </option><br />
						<option >UGANDA </option><br />
						<option >UK </option><br />
						<option >UKRAINE </option><br />
						<option >FORENEDE ARABISKE EMIRATER </option><br />
						<option >USA </option><br />

						<option >USBEKISTAN </option><br />
						<option >VENEZUELA </option><br />
						<option >VIETNAM </option><br />
						<option >YEMEN </option><br />
						<option >ZAMBIA </option><br />
						<option >ZIMBABWE </option><br />

						<option >ØSTRIG </option><br />
					</select>
</td>
</tr>
</table>
<input type="hidden" id='text_0' value=' Fastnet - 0,89 DKK '/>
<input type="hidden" id='text2_0' value=' Mobil - 1,49 DKK'/>
<input type="hidden" id='text_1' value=' Fastnet - 0,49 DKK '/>
<input type="hidden" id='text2_1' value=' Mobil - 1,89 DKK'/>
<input type="hidden" id='text_2' value=' Fastnet - 0,39 DKK '/>
<input type="hidden" id='text2_2' value=' Mobil - 1,49 DKK'/>
<input type="hidden" id='text_3' value=' Fastnet - 0,35 DKK '/>
<input type="hidden" id='text2_3' value=' Mobil - 1,75 DKK'/>
<input type="hidden" id='text_4' value=' Fastnet - 1,89 DKK '/>
<input type="hidden" id='text2_4' value=' Mobil - 1,89 DKK'/>
<input type="hidden" id='text_5' value=' Fastnet - 1,89 DKK '/>

<input type="hidden" id='text2_5' value=' Mobil - 1,89 DKK'/>
<input type="hidden" id='text_6' value=' Fastnet - 2,00 DKK '/>
<input type="hidden" id='text2_6' value=' Mobil - 2,00 DKK'/>
<input type="hidden" id='text_7' value=' Fastnet - 0,04 DKK '/>
<input type="hidden" id='text2_7' value=' Mobil - 1 DKK'/>
<input type="hidden" id='text_8' value=' Fastnet - 0,59 DKK '/>
<input type="hidden" id='text2_8' value=' Mobil - 1,15 DKK'/>
<input type="hidden" id='text_9' value=' Fastnet - 1,00 DKK '/>
<input type="hidden" id='text2_9' value=' Mobil - 1,49 DKK'/>
<input type="hidden" id='text_10' value=' Fastnet - 0,04 DKK '/>
<input type="hidden" id='text2_10' value=' Mobil - 0,89 DKK'/>
<input type="hidden" id='text_11' value=' Fastnet - 1,29 DKK '/>
<input type="hidden" id='text2_11' value=' Mobil - 1,59 DKK'/>
<input type="hidden" id='text_12' value=' Fastnet - 0,49 DKK '/>
<input type="hidden" id='text2_12' value=' Mobil - 0,49 DKK'/>
<input type="hidden" id='text_13' value=' Fastnet - 0,04 DKK '/>
<input type="hidden" id='text2_13' value=' Mobil - 0,1 DKK'/>

<input type="hidden" id='text_14' value=' Fastnet - 0,99 DKK '/>
<input type="hidden" id='text2_14' value=' Mobil - 1,29 DKK'/>
<input type="hidden" id='text_15' value=' Fastnet - 1,39 DKK '/>
<input type="hidden" id='text2_15' value=' Mobil - 1,99 DKK'/>
<input type="hidden" id='text_16' value=' Fastnet - 0,04 DKK '/>
<input type="hidden" id='text2_16' value=' Mobil - 1,49 DKK'/>
<input type="hidden" id='text_17' value=' Fastnet - 1,79 DKK '/>
<input type="hidden" id='text2_17' value=' Mobil - 1,79 DKK'/>
<input type="hidden" id='text_18' value=' Fastnet - 1,15 DKK '/>
<input type="hidden" id='text2_18' value=' Mobil - 1,15 DKK'/>
<input type="hidden" id='text_19' value=' Fastnet - 1,09 DKK '/>
<input type="hidden" id='text2_19' value=' Mobil - 1,09 DKK'/>
<input type="hidden" id='text_20' value=' Fastnet - 0,59 DKK '/>
<input type="hidden" id='text2_20' value=' Mobil - 0,89 DKK'/>
<input type="hidden" id='text_21' value=' Fastnet - 0,79 DKK '/>
<input type="hidden" id='text2_21' value=' Mobil - 1,65 DKK'/>
<input type="hidden" id='text_22' value=' Fastnet - 1 DKK '/>

<input type="hidden" id='text2_22' value=' Mobil - 1,39 DKK'/>
<input type="hidden" id='text_23' value=' Fastnet - 0,04 DKK '/>
<input type="hidden" id='text2_23' value=' Mobil - 0,99 DKK'/>
<input type="hidden" id='text_24' value=' Fastnet - 1,00 DKK '/>
<input type="hidden" id='text2_24' value=' Mobil - 1,00 DKK'/>
<input type="hidden" id='text_25' value=' Fastnet - 0,29 DKK '/>
<input type="hidden" id='text2_25' value=' Mobil - 2,09 DKK'/>
<input type="hidden" id='text_26' value=' Fastnet - 1,00 DKK '/>
<input type="hidden" id='text2_26' value=' Mobil - 1,39 DKK'/>
<input type="hidden" id='text_27' value=' Fastnet - 0,75 DKK '/>
<input type="hidden" id='text2_27' value=' Mobil - 0,99 DKK'/>
<input type="hidden" id='text_28' value=' Fastnet - 1,00 DKK '/>
<input type="hidden" id='text2_28' value=' Mobil - 1,00 DKK'/>
<input type="hidden" id='text_29' value=' Fastnet - 0,49 DKK '/>
<input type="hidden" id='text2_29' value=' Mobil - 1,09 DKK'/>
<input type="hidden" id='text_30' value=' Fastnet - 0,04 DKK '/>
<input type="hidden" id='text2_30' value=' Mobil - 0,1 DKK'/>

<input type="hidden" id='text_31' value=' Fastnet - 1,49 DKK '/>
<input type="hidden" id='text2_31' value=' Mobil - 1,89 DKK'/>
<input type="hidden" id='text_32' value=' Fastnet - 1,00 DKK '/>
<input type="hidden" id='text2_32' value=' Mobil - 1,49 DKK'/>
<input type="hidden" id='text_33' value=' Fastnet - 1,99 DKK '/>
<input type="hidden" id='text2_33' value=' Mobil - 1,99 DKK'/>
<input type="hidden" id='text_34' value=' Fastnet - 1,09 DKK '/>
<input type="hidden" id='text2_34' value=' Mobil - 1,49 DKK'/>
<input type="hidden" id='text_35' value=' Fastnet - 0,19 DKK '/>
<input type="hidden" id='text2_35' value=' Mobil - 0,99 DKK'/>
<input type="hidden" id='text_36' value=' Fastnet - 0 DKK '/>
<input type="hidden" id='text2_36' value=' Mobil - 0 DKK'/>
<input type="hidden" id='text_37' value=' Fastnet - 0,19 DKK '/>
<input type="hidden" id='text2_37' value=' Mobil - 0,49 DKK'/>
<input type="hidden" id='text_38' value=' Fastnet - 0,39 DKK '/>
<input type="hidden" id='text2_38' value=' Mobil - 0,39 DKK'/>
<input type="hidden" id='text_39' value=' Fastnet - 0,29 DKK '/>

<input type="hidden" id='text2_39' value=' Mobil - 1,29 DKK'/>
<input type="hidden" id='text_40' value=' Fastnet - 0,04 DKK '/>
<input type="hidden" id='text2_40' value=' Mobil - 0,49 DKK'/>
<input type="hidden" id='text_41' value=' Fastnet - 0,04 DKK '/>
<input type="hidden" id='text2_41' value=' Mobil - 0,99 DKK'/>
<input type="hidden" id='text_42' value=' Fastnet - 1,89 DKK '/>
<input type="hidden" id='text2_42' value=' Mobil - 1,89 DKK'/>
<input type="hidden" id='text_43' value=' Fastnet - 3,00 DKK '/>
<input type="hidden" id='text2_43' value=' Mobil - 3,00 DKK'/>
<input type="hidden" id='text_44' value=' Fastnet - 1,00 DKK '/>
<input type="hidden" id='text2_44' value=' Mobil - 1,49 DKK'/>
<input type="hidden" id='text_45' value=' Fastnet - 0,39 DKK '/>
<input type="hidden" id='text2_45' value=' Mobil - 0,79 DKK'/>
<input type="hidden" id='text_46' value=' Fastnet - 0,75 DKK '/>
<input type="hidden" id='text2_46' value=' Mobil - 1,39 DKK'/>
<input type="hidden" id='text_47' value=' Fastnet - 0,39 DKK '/>
<input type="hidden" id='text2_47' value=' Mobil - 0,39 DKK'/>

<input type="hidden" id='text_48' value=' Fastnet - 0,99 DKK '/>
<input type="hidden" id='text2_48' value=' Mobil - 0,99 DKK'/>
<input type="hidden" id='text_49' value=' Fastnet - 0,04 DKK '/>
<input type="hidden" id='text2_49' value=' Mobil - 1,99 DKK'/>
<input type="hidden" id='text_50' value=' Fastnet - 1,29 DKK '/>
<input type="hidden" id='text2_50' value=' Mobil - 1,79 DKK'/>
<input type="hidden" id='text_51' value=' Fastnet - 0,49 DKK '/>
<input type="hidden" id='text2_51' value=' Mobil - 1,29 DKK'/>
<input type="hidden" id='text_52' value=' Fastnet - 1,49 DKK '/>
<input type="hidden" id='text2_52' value=' Mobil - 1,49 DKK'/>
<input type="hidden" id='text_53' value=' Fastnet - 0,04 DKK '/>
<input type="hidden" id='text2_53' value=' Mobil - 0,75 DKK'/>
<input type="hidden" id='text_54' value=' Fastnet - 0,04 DKK '/>
<input type="hidden" id='text2_54' value=' Mobil - 0,69 DKK'/>
<input type="hidden" id='text_55' value=' Fastnet - 0,99 DKK '/>
<input type="hidden" id='text2_55' value=' Mobil - 1,99 DKK'/>
<input type="hidden" id='text_56' value=' Fastnet - 0,99 DKK '/>

<input type="hidden" id='text2_56' value=' Mobil - 1,39 DKK'/>
<input type="hidden" id='text_57' value=' Fastnet - 1,99 DKK '/>
<input type="hidden" id='text2_57' value=' Mobil - 2,19 DKK'/>
<input type="hidden" id='text_58' value=' Fastnet - 0,49 DKK '/>
<input type="hidden" id='text2_58' value=' Mobil - 0,99 DKK'/>
<input type="hidden" id='text_59' value=' Fastnet - 0 DKK '/>
<input type="hidden" id='text2_59' value=' Mobil - 1,09 DKK'/>
<input type="hidden" id='text_60' value=' Fastnet - 0,29 DKK '/>
<input type="hidden" id='text2_60' value=' Mobil - 1,09 DKK'/>
<input type="hidden" id='text_61' value=' Fastnet - 0,49 DKK '/>
<input type="hidden" id='text2_61' value=' Mobil - 1,99 DKK'/>
<input type="hidden" id='text_62' value=' Fastnet - 0,04 DKK '/>
<input type="hidden" id='text2_62' value=' Mobil - 0,89 DKK'/>
<input type="hidden" id='text_63' value=' Fastnet - 2,99 DKK '/>
<input type="hidden" id='text2_63' value=' Mobil - 4,49 DKK'/>
<input type="hidden" id='text_64' value=' Fastnet - 0,99 DKK '/>
<input type="hidden" id='text2_64' value=' Mobil - 1,49 DKK'/>

<input type="hidden" id='text_65' value=' Fastnet - 0,49 DKK '/>
<input type="hidden" id='text2_65' value=' Mobil - 1,89 DKK'/>
<input type="hidden" id='text_66' value=' Fastnet - 0,89 DKK '/>
<input type="hidden" id='text2_66' value=' Mobil - 0,89 DKK'/>
<input type="hidden" id='text_67' value=' Fastnet - 2,25 DKK '/>
<input type="hidden" id='text2_67' value=' Mobil - 2,25 DKK'/>
<input type="hidden" id='text_68' value=' Fastnet - 1,89 DKK '/>
<input type="hidden" id='text2_68' value=' Mobil - 1,89 DKK'/>
<input type="hidden" id='text_69' value=' Fastnet - 1,29 DKK '/>
<input type="hidden" id='text2_69' value=' Mobil - 1,89 DKK'/>
<input type="hidden" id='text_70' value=' Fastnet - 0,04 DKK '/>
<input type="hidden" id='text2_70' value=' Mobil - 0,89 DKK'/>
<input type="hidden" id='text_71' value=' Fastnet - 1,49 DKK '/>
<input type="hidden" id='text2_71' value=' Mobil - 1,49 DKK'/>
<input type="hidden" id='text_72' value=' Fastnet - 0,04 DKK '/>
<input type="hidden" id='text2_72' value=' Mobil - 0,19 DKK'/>
<input type="hidden" id='text_73' value=' Fastnet - 0,04 DKK '/>

<input type="hidden" id='text2_73' value=' Mobil - 0,75 DKK'/>
<input type="hidden" id='text_74' value=' Fastnet - 0,04 DKK '/>
<input type="hidden" id='text2_74' value=' Mobil - 1,49 DKK'/>
<input type="hidden" id='text_75' value=' Fastnet - 0 DKK '/>
<input type="hidden" id='text2_75' value=' Mobil - 0 DKK'/>
<input type="hidden" id='text_76' value=' Fastnet - 0,29 DKK '/>
<input type="hidden" id='text2_76' value=' Mobil - 0,69 DKK'/>
<input type="hidden" id='text_77' value=' Fastnet - 0,29 DKK '/>
<input type="hidden" id='text2_77' value=' Mobil - 0,59 DKK'/>
<input type="hidden" id='text_78' value=' Fastnet - 0,04 DKK '/>
<input type="hidden" id='text2_78' value=' Mobil - 0,49 DKK'/>
<input type="hidden" id='text_79' value=' Fastnet - 0,04 DKK '/>
<input type="hidden" id='text2_79' value=' Mobil - 1,39 DKK'/>
<input type="hidden" id='text_80' value=' Fastnet - 0,04 DKK '/>
<input type="hidden" id='text2_80' value=' Mobil - 0,49 DKK'/>
<input type="hidden" id='text_81' value=' Fastnet - 1,39 DKK '/>
<input type="hidden" id='text2_81' value=' Mobil - 1,39 DKK'/>

<input type="hidden" id='text_82' value=' Fastnet - 0,04 DKK '/>
<input type="hidden" id='text2_82' value=' Mobil - 1,39 DKK'/>
<input type="hidden" id='text_83' value=' Fastnet - 1,49 DKK '/>
<input type="hidden" id='text2_83' value=' Mobil - 1,75 DKK'/>
<input type="hidden" id='text_84' value=' Fastnet - 0,69 DKK '/>
<input type="hidden" id='text2_84' value=' Mobil - 1,29 DKK'/>
<input type="hidden" id='text_85' value=' Fastnet - 0,19 DKK '/>
<input type="hidden" id='text2_85' value=' Mobil - 0,89 DKK'/>
<input type="hidden" id='text_86' value=' Fastnet - 0,04 DKK '/>
<input type="hidden" id='text2_86' value=' Mobil - 0,19 DKK'/>
<input type="hidden" id='text_87' value=' Fastnet - 0,99 DKK '/>
<input type="hidden" id='text2_87' value=' Mobil - 0,99 DKK'/>
<input type="hidden" id='text_88' value=' Fastnet - 0,29 DKK '/>
<input type="hidden" id='text2_88' value=' Mobil - 0,49 DKK'/>
<input type="hidden" id='text_89' value=' Fastnet - 4,00 DKK '/>
<input type="hidden" id='text2_89' value=' Mobil - 4,00 DKK'/>
<input type="hidden" id='text_90' value=' Fastnet - 0,19 DKK '/>

<input type="hidden" id='text2_90' value=' Mobil - 0,39 DKK'/>
<input type="hidden" id='text_91' value=' Fastnet - 0,29 DKK '/>
<input type="hidden" id='text2_91' value=' Mobil - 0,69 DKK'/>
<input type="hidden" id='text_92' value=' Fastnet - 0,99 DKK '/>
<input type="hidden" id='text2_92' value=' Mobil - 0,99 DKK'/>
<input type="hidden" id='text_93' value=' Fastnet - 0,49 DKK '/>
<input type="hidden" id='text2_93' value=' Mobil - 0,49 DKK'/>
<input type="hidden" id='text_94' value=' Fastnet - 0,04 DKK '/>
<input type="hidden" id='text2_94' value=' Mobil - 0,99 DKK'/>
<input type="hidden" id='text_95' value=' Fastnet - 0,35 DKK '/>
<input type="hidden" id='text2_95' value=' Mobil - 0,99 DKK'/>
<input type="hidden" id='text_96' value=' Fastnet - 1,49 DKK '/>
<input type="hidden" id='text2_96' value=' Mobil - 1,49 DKK'/>
<input type="hidden" id='text_97' value=' Fastnet - 1,69 DKK '/>
<input type="hidden" id='text2_97' value=' Mobil - 1,69 DKK'/>
<input type="hidden" id='text_98' value=' Fastnet - 1,49 DKK '/>
<input type="hidden" id='text2_98' value=' Mobil - 1,89 DKK'/>

<input type="hidden" id='text_99' value=' Fastnet - 0,39 DKK '/>
<input type="hidden" id='text2_99' value=' Mobil - 3,29 DKK'/>
<input type="hidden" id='text_100' value=' Fastnet - 0,04 DKK '/>
<input type="hidden" id='text2_100' value=' Mobil - 0,69 DKK'/>
<input type="hidden" id='text_101' value=' Fastnet - 0,04 DKK '/>
<input type="hidden" id='text2_101' value=' Mobil - 1,49 DKK'/>
<input type="hidden" id='text_102' value=' Fastnet - 0,29 DKK '/>
<input type="hidden" id='text2_102' value=' Mobil - 0,29 DKK'/>
<input type="hidden" id='text_103' value=' Fastnet - 0,29 DKK '/>
<input type="hidden" id='text2_103' value=' Mobil - 1,79 DKK'/>
<input type="hidden" id='text_104' value=' Fastnet - 1,89 DKK '/>
<input type="hidden" id='text2_104' value=' Mobil - 1,89 DKK'/>
<input type="hidden" id='text_105' value=' Fastnet - 0,69 DKK '/>
<input type="hidden" id='text2_105' value=' Mobil - 0,89 DKK'/>
<input type="hidden" id='text_106' value=' Fastnet - 0,19 DKK '/>
<input type="hidden" id='text2_106' value=' Mobil - 0,19 DKK'/>
<input type="hidden" id='text_107' value=' Fastnet - 2,29 DKK '/>

<input type="hidden" id='text2_107' value=' Mobil - 2,00 DKK'/>
<input type="hidden" id='text_108' value=' Fastnet - 1,79 DKK '/>
<input type="hidden" id='text2_108' value=' Mobil - 1,99 DKK'/>
<input type="hidden" id='text_109' value=' Fastnet - 0,04 DKK '/>
<input type="hidden" id='text2_109' value=' Mobil - 1,39 DKK'/>
<input type="hidden" id='text_110' value=' Fastnet - 0,69 DKK '/>
<input type="hidden" id='text2_110' value=' Mobil - 1,99 DKK'/>
<input type="hidden" id='text_111' value=' Fastnet - 1,89 DKK '/>
<input type="hidden" id='text2_111' value=' Mobil - 1,89 DKK'/>
<input type="hidden" id='text_112' value=' Fastnet - 0,99 DKK '/>
<input type="hidden" id='text2_112' value=' Mobil - 0,99 DKK'/>
<input type="hidden" id='text_113' value=' Fastnet - 0,29 DKK '/>
<input type="hidden" id='text2_113' value=' Mobil - 0,89 DKK'/>
<input type="hidden" id='text_114' value=' Fastnet - 0,89 DKK '/>
<input type="hidden" id='text2_114' value=' Mobil - 1,29 DKK'/>
<input type="hidden" id='text_115' value=' Fastnet - 0,19 DKK '/>
<input type="hidden" id='text2_115' value=' Mobil - 1,79 DKK'/>

<input type="hidden" id='text_116' value=' Fastnet - 0,69 DKK '/>
<input type="hidden" id='text2_116' value=' Mobil - 0,69 DKK'/>
<input type="hidden" id='text_117' value=' Fastnet - 0,49 DKK '/>
<input type="hidden" id='text2_117' value=' Mobil - 1,79 DKK'/>
<input type="hidden" id='text_118' value=' Fastnet - 0,59 DKK '/>
<input type="hidden" id='text2_118' value=' Mobil - 1,19 DKK'/>
<input type="hidden" id='text_119' value=' Fastnet - 1,89 DKK '/>
<input type="hidden" id='text2_119' value=' Mobil - 1,89 DKK'/>
<input type="hidden" id='text_120' value=' Fastnet - 0,59 DKK '/>
<input type="hidden" id='text2_120' value=' Mobil - 1,49 DKK'/>
<input type="hidden" id='text_121' value=' Fastnet - 7,00 DKK '/>
<input type="hidden" id='text2_121' value=' Mobil - ,00DKK'/>
<input type="hidden" id='text_122' value=' Fastnet - 0,99 DKK '/>
<input type="hidden" id='text2_122' value=' Mobil - 0,99 DKK'/>
<input type="hidden" id='text_123' value=' Fastnet - 1,89 DKK '/>
<input type="hidden" id='text2_123' value=' Mobil - 1,89 DKK'/>
<input type="hidden" id='text_124' value=' Fastnet - 0,04 DKK '/>

<input type="hidden" id='text2_124' value=' Mobil - 1,39 DKK'/>
<input type="hidden" id='text_125' value=' Fastnet - 0,99 DKK '/>
<input type="hidden" id='text2_125' value=' Mobil - 1,09 DKK'/>
<input type="hidden" id='text_126' value=' Fastnet - 0,29 DKK '/>
<input type="hidden" id='text2_126' value=' Mobil - 0,59 DKK'/>
<input type="hidden" id='text_127' value=' Fastnet - 0,04 DKK '/>
<input type="hidden" id='text2_127' value=' Mobil - 0,99 DKK'/>
<input type="hidden" id='text_128' value=' Fastnet - 1,49 DKK '/>
<input type="hidden" id='text2_128' value=' Mobil - 1,79 DKK'/>
<input type="hidden" id='text_129' value=' Fastnet - 0 DKK '/>
<input type="hidden" id='text2_129' value=' Mobil - 0 DKK'/>
<input type="hidden" id='text_130' value=' Fastnet - 1,99 DKK '/>
<input type="hidden" id='text2_130' value=' Mobil - 1,99 DKK'/>
<input type="hidden" id='text_131' value=' Fastnet - 0,59 DKK '/>
<input type="hidden" id='text2_131' value=' Mobil - 1,29 DKK'/>
<input type="hidden" id='text_132' value=' Fastnet - 0,79 DKK '/>
<input type="hidden" id='text2_132' value=' Mobil - 0,99 DKK'/>

<input type="hidden" id='text_133' value=' Fastnet - 0,29 DKK '/>
<input type="hidden" id='text2_133' value=' Mobil - 0,89 DKK'/>
<input type="hidden" id='text_134' value=' Fastnet - 0,39 DKK '/>
<input type="hidden" id='text2_134' value=' Mobil - 0,89 DKK'/>
<input type="hidden" id='text_135' value=' Fastnet - 0,04 DKK '/>
<input type="hidden" id='text2_135' value=' Mobil - 0,99 DKK'/>
<input type="hidden" id='text_136' value=' Fastnet - 0,04 DKK '/>
<input type="hidden" id='text2_136' value=' Mobil - 0,99 DKK'/>
<input type="hidden" id='text_137' value=' Fastnet - 1,79 DKK '/>
<input type="hidden" id='text2_137' value=' Mobil - 1,79 DKK'/>
<input type="hidden" id='text_138' value=' Fastnet - 0,99 DKK '/>
<input type="hidden" id='text2_138' value=' Mobil - 1,99 DKK'/>
<input type="hidden" id='text_139' value=' Fastnet - 0,04 DKK '/>
<input type="hidden" id='text2_139' value=' Mobil - 0,49 DKK'/>
<input type="hidden" id='text_140' value=' Fastnet - 0,04 DKK '/>
<input type="hidden" id='text2_140' value=' Mobil - 0,29 DKK'/>
<input type="hidden" id='text_141' value=' Fastnet - 0,69 DKK '/>

<input type="hidden" id='text2_141' value=' Mobil - 0,99 DKK'/>
<input type="hidden" id='text_142' value=' Fastnet - 0,39 DKK '/>
<input type="hidden" id='text2_142' value=' Mobil - 0,89 DKK'/>
<input type="hidden" id='text_143' value=' Fastnet - 0,99 DKK '/>
<input type="hidden" id='text2_143' value=' Mobil - 1,49 DKK'/>
<input type="hidden" id='text_144' value=' Fastnet - 0,39 DKK '/>
<input type="hidden" id='text2_144' value=' Mobil - 1,49 DKK'/>
<input type="hidden" id='text_145' value=' Fastnet - 0,99 DKK '/>
<input type="hidden" id='text2_145' value=' Mobil - 0,99 DKK'/>
<input type="hidden" id='text_146' value=' Fastnet - 2,49 DKK '/>
<input type="hidden" id='text2_146' value=' Mobil - 2,49 DKK'/>
<input type="hidden" id='text_147' value=' Fastnet - 0,19 DKK '/>
<input type="hidden" id='text2_147' value=' Mobil - 0,19 DKK'/>
<input type="hidden" id='text_148' value=' Fastnet - 0,04 DKK '/>
<input type="hidden" id='text2_148' value=' Mobil - 1,35 DKK'/>
<input type="hidden" id='text_149' value=' Fastnet - 0,04 DKK '/>
<input type="hidden" id='text2_149' value=' Mobil - 1,49 DKK'/>

<input type="hidden" id='text_150' value=' Fastnet - 3,29 DKK '/>
<input type="hidden" id='text2_150' value=' Mobil - 3,29 DKK'/>
<input type="hidden" id='text_151' value=' Fastnet - 0,04 DKK '/>
<input type="hidden" id='text2_151' value=' Mobil - 0,99 DKK'/>
<input type="hidden" id='text_152' value=' Fastnet - 0,04 DKK '/>
<input type="hidden" id='text2_152' value=' Mobil - 0,79 DKK'/>
<input type="hidden" id='text_153' value=' Fastnet - 0,55 DKK '/>
<input type="hidden" id='text2_153' value=' Mobil - 0,75 DKK'/>
<input type="hidden" id='text_154' value=' Fastnet - 1,00 DKK '/>
<input type="hidden" id='text2_154' value=' Mobil - 2,00 DKK'/>
<input type="hidden" id='text_155' value=' Fastnet - 2,00 DKK '/>
<input type="hidden" id='text2_155' value=' Mobil - 2,00 DKK'/>
<input type="hidden" id='text_156' value=' Fastnet - 2,00 DKK '/>
<input type="hidden" id='text2_156' value=' Mobil - 2,00 DKK'/>
<input type="hidden" id='text_157' value=' Fastnet - 0,69 DKK '/>
<input type="hidden" id='text2_157' value=' Mobil - 0,89 DKK'/>
<input type="hidden" id='text_158' value=' Fastnet - 1,49 DKK '/>

<input type="hidden" id='text2_158' value=' Mobil - 1,49 DKK'/>
<input type="hidden" id='text_159' value=' Fastnet - 0,99 DKK '/>
<input type="hidden" id='text2_159' value=' Mobil - 1,29 DKK'/>
<input type="hidden" id='text_160' value=' Fastnet - 0,04 DKK '/>
<input type="hidden" id='text2_160' value=' Mobil - 0,19 DKK'/>
<input type="hidden" id='text_161' value=' Fastnet - 0,04 DKK '/>
<input type="hidden" id='text2_161' value=' Mobil - 1,89 DKK'/>
<input type="hidden" id='text_162' value=' Fastnet - 0,49 DKK '/>
<input type="hidden" id='text2_162' value=' Mobil - 0,99 DKK'/>
<input type="hidden" id='text_163' value=' Fastnet - 0,29 DKK '/>
<input type="hidden" id='text2_163' value=' Mobil - 0,69 DKK'/>
<input type="hidden" id='text_164' value=' Fastnet - 0,99 DKK '/>
<input type="hidden" id='text2_164' value=' Mobil - 0,99 DKK'/>
<input type="hidden" id='text_165' value=' Fastnet - 0,49 DKK '/>
<input type="hidden" id='text2_165' value=' Mobil - 0,89 DKK'/>
<input type="hidden" id='text_166' value=' Fastnet - 0 DKK '/>
<input type="hidden" id='text2_166' value=' Mobil - 0 DKK'/>

<input type="hidden" id='text_167' value=' Fastnet - 2,29 DKK '/>
<input type="hidden" id='text2_167' value=' Mobil - 2,29 DKK'/>
<input type="hidden" id='text_168' value=' Fastnet - 2,00 DKK '/>
<input type="hidden" id='text2_168' value=' Mobil - 2,00 DKK'/>
<input type="hidden" id='text_169' value=' Fastnet - 0,79 DKK '/>
<input type="hidden" id='text2_169' value=' Mobil - 0,79 DKK'/>
<input type="hidden" id='text_170' value=' Fastnet - 1,29 DKK '/>
<input type="hidden" id='text2_170' value=' Mobil - 2,09 DKK'/>
<input type="hidden" id='text_171' value=' Fastnet - 0 DKK '/>
<input type="hidden" id='text2_171' value=' Mobil - 0 DKK'/>
<input type="hidden" id='text_172' value=' Fastnet - 0,69 DKK '/>
<input type="hidden" id='text2_172' value=' Mobil - 0,89 DKK'/>
<input type="hidden" id='text_173' value=' Fastnet - 0,04 DKK '/>
<input type="hidden" id='text2_173' value=' Mobil - 1,09 DKK'/>
<input type="hidden" id='text_174' value=' Fastnet - 0,29 DKK '/>
<input type="hidden" id='text2_174' value=' Mobil - 0,69 DKK'/>
<input type="hidden" id='text_175' value=' Fastnet - 0,69 DKK '/>

<input type="hidden" id='text2_175' value=' Mobil - 0,69 DKK'/>
<input type="hidden" id='text_176' value=' Fastnet - 0,04 DKK '/>
<input type="hidden" id='text2_176' value=' Mobil - 0,10 DKK'/>
<input type="hidden" id='text_177' value=' Fastnet - 0,59 DKK '/>
<input type="hidden" id='text2_177' value=' Mobil - 0,59 DKK'/>
<input type="hidden" id='text_178' value=' Fastnet - 0,19 DKK '/>
<input type="hidden" id='text2_178' value=' Mobil - 0,39 DKK'/>
<input type="hidden" id='text_179' value=' Fastnet - 0,04 DKK '/>
<input type="hidden" id='text2_179' value=' Mobil - 0,10 DKK'/>
<input type="hidden" id='text_180' value=' Fastnet - 0,99 DKK '/>
<input type="hidden" id='text2_180' value=' Mobil - 0,99 DKK'/>
<input type="hidden" id='text_181' value=' Fastnet - 0,39 DKK '/>
<input type="hidden" id='text2_181' value=' Mobil - 0,89 DKK'/>
<input type="hidden" id='text_182' value=' Fastnet - 0,29 DKK '/>
<input type="hidden" id='text2_182' value=' Mobil - 2,00 DKK'/>
<input type="hidden" id='text_183' value=' Fastnet - 0,04 DKK '/>
<input type="hidden" id='text2_183' value=' Mobil - 0,59 DKK'/>

<p>	<!-- Result show here --></p>
<ul>
<li class="price">Opkald til denne destination er:</li>
<li id="lable" class="price">Fastnet - 0 DKK </li>
<li id="lable2" class="price">Mobil - 0 DKK </li>
<li class="price">*Du betaler for lokal mobil takst for at ringe til vores hovednummer</li>
</ul>
