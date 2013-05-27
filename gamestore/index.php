<?php

/**
 * @package     JohnCMS
 * @link        http://johncms.com
 * @copyright   Copyright (C) 2008-2011 JohnCMS Community
 * @license     LICENSE.txt (see attached file)
 * @version     VERSION.txt (see attached file)
 * @author      http://johncms.com/about
 */

define('_IN_JOHNCMS', 1);

require('../incfiles/core.php');	
require('../incfiles/head.php');

$act = $_GET['act'];
$id = $_GET['id'];
$src = $_GET['src'];

switch($act){
	case 'download':
		require_once('../Tera-Wurfl/TeraWurfl.php');
		$wurflObj = new TeraWurfl();
		$matched = $wurflObj->getDeviceCapabilitiesFromAgent($_GET['']);
	
		$width = $wurflObj->getDeviceCapability("resolution_width");
		$height = $wurflObj->getDeviceCapability("resolution_height");
		$brand = $wurflObj->getDeviceCapability("brand_name");
		$model = $wurflObj->getDeviceCapability("model_name");
		$os = $wurflObj->getDeviceCapability("device_os");
		$os_version = $wurflObj->getDeviceCapability("device_os_version");
		echo 'OS: '.$os;
		echo '<br/>Brand: '.$brand;
		echo '<br/>Model: '.$model;
		die();
		if($id == 1){
			//header('Location: store/vankiem/Sword_L240X320_NK.jar');
		
		?>
			<p>Hệ thống không xác định được dòng máy của bạn, bạn hãy chọn dòng máy phù hợp để tải về.</p>
			<h4>Nokia : 2700(240*320)</h4>
				Tải về: <a href="store/vankiem/Sword_L240X320_NK.jar">Jar</a> | <a href="store/vankiem/Sword_L240X320_NK.jad">Jad</a>
				<p>2730;2700C;2710;2600c;6303; 7210S;6600S;7230;6316;5220XM; 8800GA;8600L; 7900P;7610S;7500;7373;7310S; 6600F;6600i;6555;6500S;6500C; 6301; 6300I;6300;6100;6267;6263; 6234;6233;6212C;6133;6131N; 6131;6126; 5610XM;5310XM;5300XM;5130XM; 5132XM;3600S;3120C;7020;6260; 3120c; 5610;5610XM;6126;6233;6234; 6555;C2-08</p>
			<h4>Nokia : N73(240*320)</h4>
				Tải về: <a href="store/vankiem/Sword_S320X240_NK.jar">Jar</a> | <a href="store/vankiem/Sword_S320X240_NK.jad">Jad</a>
				<p>X3; X2; X3-01; C3; N75; N73; N71; E65; E50; E51; N96; N92; N75; N73; N71; N76; N8; E65; E50; N96; N92; 6788; 6788i; N95; N95 8GB; N93i; N93; N82; N85; N81;; N79; N78; E75; 6650F; 6220C; 6210N; 6120C; 6110; 5700XM; 5730XM; 5320XM; N86; E55; 6720C;6710N; 5630XM ; C5; E66; 6700; 6700S; 6702; E5; E52; 6730; X5-01; 6760; 6290</p>
			<h4>Nokia : E71(320*240)</h4>
				Tải về: <a href="store/vankiem/Sword_S240X320_NK.jar">Jar</a> | <a href="store/vankiem/Sword_S240X320_NK.jad">Jad</a>
				<p>E71; E61; E61i; E62; E63; E72; E72i; E73; E73i</p>
			<h4>Nokia : N5800 (640*360)</h4>
				Tải về: <a href="store/vankiem/Sword_H640X360_NK.jar">Jar</a> | <a href="store/vankiem/Sword_H640X360_NK.jad">Jad</a>
				<p>5230; 5800d; 5233; c6; c6-00; c5-02; c5-03; n97; x6; 5530; 5235; 5530c; n97mini; 5232 ; c7; 5802xm; 5228; 5250; 5800i ; e7; N97i; Nuron; Saga</p>
			<h4>MOTOROLA : A1200 (240*320)</h4>
				Tải về: <a href="store/vankiem/Sword_T240X320_MO.jar">Jar</a> | <a href="store/vankiem/Sword_T240X320_MO.jad">Jad</a>
				<p>E8; Motorokr_E8; V3xx;V1100; A780; E680i; A1200; A910; E1070; E6; Ming; Motorokr_E2; Motorokr_E6;A1200e,E6e</p>
			<h4>MOTOROLA : V8</h4>
				Tải về: <a href="store/vankiem/Sword_S240X320_MO.jar">Jar</a> | <a href="store/vankiem/Sword_S240X320_MO.jad">Jad</a>
				<p>MotoRazr2V8; Motorokr_E2; Razr2V8 ; Z6</p>
			<h4>MOTOROLA : Q8 (240 x 320)</h4>
				Tải về: <a href="store/vankiem/Sword_S320X240_MO.jar">Jar</a> | <a href="store/vankiem/Sword_S320X240_MO.jad">Jad</a>
				<p>Q8 ; Q9</p>
			<h4>HTC : Dopod 838</h4>
				Tải về: <a href="store/vankiem/Sword_T240X320_DP.jar">Jar</a> | <a href="store/vankiem/Sword_T240X320_DP.jad">Jad</a>
				<p>Touch DUAL; S640; S600; S1; P860; P800; P660; P6500; P4550; P4450; 3450; E616; D805; D802; D600; C858g; C750; C730w; C730; 838; 830; 828; 710; 96; 686; 586; 566; T4288; T3238; T2222; S730; S700; S640; S610; S600; S505; 500; P863; MUSE; M700; E806C; E616; D810; D805; D802; D600; C858; C750; C730W; C730; 9000; 838; 830; 828+; 828; 818; 700; 699; 696; 686; Hermes; Himalaya; P3600; P3650; P3700; Polaris; S620; S621; S720; T8282; Tilt; Titan; Tornado; Trinity; TyTN; Vox; Wizard Qtek 8310;Qtek 9100; Qtek XDAII</p>
			<h4>HTC : Dopod 818</h4>
				Tải về: <a href="store/vankiem/Sword_S320X240_NK.jar">Jar</a> | <a href="store/vankiem/Sword_S320X240_NK.jad">Jad</a>
				<p>S500; S500c; K770; K790; K790i; K800; K800i; K810; K818c; K898c; T650; T658c; W818c; W580c; W830; W830c; W850; W858c; W880; W888c; W898c; W43s; W595c; C702; C902; W760; W760i; W800; W800i; W850i; W880; W880i; W900; W900i; W908c ; W910; W910i; W950i; W960; X1; Z1010; Z750; Z770; Z800</p>
			<h4>Sony Ericsson : S500</h4>
				Tải về: <a href="store/vankiem/Sword_S240X320_SE.jar">Jar</a> | <a href="store/vankiem/Sword_S240X320_SE.jad">Jad</a>
				<p>S500; S500c; K770; K790; K790i; K800; K800i; K810; K818c; K898c; T650; T658c; W818c; W580c; W830; W830c; W850; W858c; W880; W888c; W898c; W43s; W595c; C702; C902; W760; W760i; W800; W800i; W850i; W880; W880i; W900; W900i; W908c ; W910; W910i; W950i; W960; X1; Z1010; Z750; Z770; Z800</p>
			<h4>Sony Ericsson : W950</h4>
				Tải về: <a href="store/vankiem/Sword_T240X320_SE.jar">Jar</a> | <a href="store/vankiem/Sword_T240X320_SE.jad">Jad</a>
				<p>P990; P990c; P990i; W950; W950c; W950i; W958c; W960i; M600; M608c; P1c; P3i; W960 8GB; G900; G700; P800; P802; P900; P908; P910; P910a; P910c; P910i; P990i; S700; S700c; S700i</p>
			<h4>Sam Sung : I850</h4>
				Tải về: <a href="store/vankiem/Sword_S240X320_NK.jar">Jar</a> | <a href="store/vankiem/Sword_S240X320_NK.jad">Jad</a>
				<p>i8510 ; i8510C; B5210U; i560 ; G810; G850; SGH-G818E; SGH-L870; i8510;Blackjack; SGH-P310</p>
			<h4>Sam Sung : I 900</h4>
				Tải về: <a href="store/vankiem/Sword_S240X320_NK.jar">Jar</a> | <a href="store/vankiem/Sword_S240X320_NK.jad">Jad</a>
				<p>I900; I780; M7600; SGH-i400; SGH-i520; SGH-i450; SGH-i458; SGH-D900; SGH-D908; SGH-E898; SGH-F700</p>
			<h4>ANDOIR : 480x320</h4>
				Tải về: <a href="store/vankiem/Sword_S240X320_NK.jar">Jar</a> | <a href="store/vankiem/Sword_S240X320_NK.jad">Jad</a>
				<p>I900; I780; M7600; SGH-i400; SGH-i520; SGH-i450; SGH-i458; SGH-D900; SGH-D908; SGH-E898; SGH-F700</p>
				
		<?php		
		}
		if($id == 2){
			if(strcasecmp($os, 'android') == 0){
				header('Location: store/minhchau/PearlHeroes_VN_1.01_CCABNY26.apk');
			}
			if(strcasecmp($brand, 'nokia') == 0){
				if(strcasecmp($model, '3250') == 0 || strcasecmp($model, 'N97') == 0){
					header('Location: store/minhchau/Sanguo_Nokia3250_CCABNY26.jar');
				}
				if(strcasecmp($model, '3250') == 0 || strcasecmp($model, 'N97') == 0){
					header('Location: store/minhchau/Sanguo_Nokia3250_CCABNY26.jar');
				}
				$models = array('2710n','2730c','3120c','3208c','3600s','3610f','3710f','3720c','5000','5130XM','5220XM','5310XM','5330','5330XM','5610XM','6208c','6212c','6263','6267','6300i','6301','6303c','6303i','6305','6350','6500c','6500s','6555','6600f','6600i','6600s','6700c','6750','7020','7100s','7210c','7310s','7320c','7500prism','7510s','7610s','7900prism','8800','X3','3602s','5300','5300XM','6126','6131','6131NFC','6133','6233','6234','6265','6265i','6270','6280','6282','6288','6300','6275i','7370','7373','7390','7612s','8600');
				if(in_array($model, $models )){
					header('Location: store/minhchau/Sanguo_Nokia5310XM_CCABNY26.jar');
				}
				$models = array('5800','5800i','5530','5802','5900','N97','5230','5325','X6');
				if(in_array($model, $models )){
					header('Location: store/minhchau/Sanguo_Nokia5800_CCABNY26.jar');
				}
				if(strcasecmp($model, '6681') == 0 || strcasecmp($model, '6682') == 0){
					header('Location: store/minhchau/Sanguo_Nokia6681_CCABNY26.jar');
				}
				$models = array('7610','N70','N72','3230','6260','6620','6600','6670');
				if(in_array($model, $models )){
					header('Location: store/minhchau/Sanguo_Nokia7610_CCABNY26.jar');
				}
				$models = array('E61','E61i','E62','E63','E71','E71x','E72','6790s','6760s');
				if(in_array($model, $models )){
					header('Location: store/minhchau/Sanguo_NokiaE62_CCABNY26.jar');
				}
				$models = array('N73','N71','N75','N76','N77','N78','N79','N81','N82','N85','N92','N93','N93i','N95','N96','6110N','6120c','6121c','6122c','6124c','6210N','6211c','6220c','6290','6650','5320XM','5700XM','5710XM','E50','E51','E65','E66');
				if(in_array($model, $models )){
					header('Location: store/minhchau/Sanguo_NokiaN73_CCABNY26.jar');
				}
			}
			//sony ericsion
			if(strcasecmp($brand, 'SonyEricsson') == 0){
				$models = array('K790c','W580c','W595c','W760c','W830i','W850','W850c','W850i','W880','W880i','W888c','W890i','W900','W900i','W902','W908c','W950i','W980c','W980i','K660i','K770c','K800c','K810i','K818c','K850','K850i','K858c','C702','C902','C905','G502','P990c','S500c','T658c','T700','Z750i','Z770','Z780','Z810i');
				if(in_array($model, $models )){
						header('Location: store/minhchau/Sanguo_SEK790_CCABNY26.jar');
				}
			}
			if(strcasecmp($brand, 'Motorola') == 0){
				$models = array('E2','E3','U9','V6','V8','VE358','VE66','Z6','Z6w','Z9','ZN5','E1000','V3x');
				if(in_array($model, $models )){
						header('Location: store/minhchau/Sanguo_MotoE2_CCABNY26.jar');
				}
			}
			
			if(strcasecmp($brand, 'Samsung') == 0){
				$models = array('458','G818','i408','i550','i560','i8510','L870','L878');
				if(in_array($model, $models )){
						header('Location: store/minhchau/Sanguo_3.0_CCABNY26_vn_v3.sisx');
				}
			}
			
		?>
			<p>Hệ thống không xác định được dòng máy của bạn, bạn hãy chọn dòng máy phù hợp để tải về.</p>
			<h4>Nokia 3250 (176*208)</h4>
			Tải về: <a href="store/minhchau/Sanguo_Nokia3250_CCABNY26.jar">Jar</a> | <a href="store/minhchau/Sanguo_Nokia3250_CCABNY26.jad">Jad</a>
			<p>3250,N91</p>
			<h4>Nokia 5310XM (240*320)</h4>
			Tải về: <a href="store/minhchau/Sanguo_Nokia5310XM_CCABNY26.jar">Jar</a> | <a href="store/minhchau/Sanguo_Nokia5310XM_CCABNY26.jad">Jad</a>
			<p>2710n, 2730c, 3120c, 3208c, 3600s, 3610f, 3710f, 3720c, 5000, 5130XM, 5220XM, 5310XM, 5330, 5330XM, 5610XM, 6208c, 6212c, 6263, 6267, 6300i, 6301, 6303c, 6303i, 6305, 6350, 6500c, 6500s, 6555, 6600f, 6600i, 6600s, 6700c, 6750, 7020, 7100s, 7210c, 7310s, 7320c, 7500 prism, 7510s, 7610s, 7900 prism, 8800, X3, 3602s，5300, 5300XM，6126,6131，6131NFC,6133,6233,6234, 6265,6265i,6270,6280,6282,6288,6300,6275i,7370，7373， 7390,7612s，8600</p>
			<h4>Nokia 5800</h4> 
			Tải về: <a href="store/minhchau/Sanguo_Nokia5800_CCABNY26.jar">Jar</a> | <a href="store/minhchau/Sanguo_Nokia5800_CCABNY26.jad">Jad</a>
			<p>5800，5800i，5530，5802，5900，N97，5230，5325，X6</p>
			<h4>Nokia 6681</h4>
			Tải về: <a href="store/minhchau/Sanguo_Nokia6681_CCABNY26.jar">Jar</a> | <a href="store/minhchau/Sanguo_Nokia6681_CCABNY26.jad">Jad</a>
			<p>6681,6682</p>
			<h4>Nokia 7610 (176*208)</h4>
			Tải về: <a href="store/minhchau/Sanguo_Nokia7610_CCABNY26.jar">Jar</a> | <a href="store/minhchau/Sanguo_Nokia7610_CCABNY26.jad">Jad</a>
			<p>7610, N70, N72, 3230, 6260, 6620, 6600, 6670</p>
			<h4>Nokia E62 (320*240)</h4>
			Tải về: <a href="store/minhchau/Sanguo_NokiaE62_CCABNY26.jar">Jar</a> | <a href="store/minhchau/Sanguo_NokiaE62_CCABNY26.jad">Jad</a>
			<p>E61,E61i, E62, E63, E71，E71x，E72，6790s，6760s</p>
			<h4>Nokia N73</h4>
			Tải về:  <a href="store/minhchau/Sanguo_NokiaN73_CCABNY26.jar">Jar</a> | <a href="store/minhchau/Sanguo_NokiaN73_CCABNY26.jad">Jad</a>
			<p>N73, N71, N75, N76, N77, N78, N79, N81, N82, N85, N92, N93, N93i, N95, N96, 6110N, 6120c, 6121c, 6122c, 6124c, 6210N, 6211c, 6220c, 6290, 6650, 5320XM, 5700XM, 5710XM, E50, E51, E65, E66</p>
			<h4>Sony Ericsson K790C</h4>
			Tải về: <a href="store/minhchau/Sanguo_SEK790_CCABNY26.jar">Jar</a> | <a href="store/minhchau/Sanguo_SEK790_CCABNY26.jad">Jad</a>
			<p>K790c, W580c, W595c, W760c, W830i, W850, W850c, W850i, W880, W880i, W888c, W890i, W900, W900i, W902, W908c, W950i, W980c, W980i, K660i, K770c, K800c, K810i, K818c, K850, K850i, K858c, C702, C902, C905, G502, P990c, S500c, T658c, T700, Z750i, Z770, Z780, Z810i</p>
			<h4>Motorola E2</h4>
			Tải về: <a href="store/minhchau/Sanguo_MotoE2_CCABNY26.jar">Jar</a> | <a href="store/minhchau/Sanguo_MotoE2_CCABNY26.jad">Jad</a>
			<p>E2, E3, U9, V6, V8, VE358, VE66, Z6, Z6w, Z9, ZN5，E1000，V3x</p>
			
			<h4>Samsung i458: <a href="store/minhchau/Sanguo_3.0_CCABNY26_vn_v3.sisx">Tải về</a></h4>

			<p>458,G818,i408,i550,i560,i8510,L870,L878</p>
			
			<h4>Các dòng máy Smartphone Touch</h4>
			Tải về: <a href="store/minhchau/Sanguo_Midp2Touch_CCABNY26.jar">Jar</a> | <a href="store/minhchau/Sanguo_Midp2Touch_CCABNY26.jad">Jad</a>
			<h4>Các dòng máy khác</h4>
			Tải về: <a href="store/minhchau/Sanguo_Midp2Touch_CCABNY26.jar">Jar</a> | <a href="store/minhchau/Sanguo_GenericMidp2_CCABNY26.jad">Jad</a>			
			<h4>Hệ điều hành Android: <a href="store/minhchau/PearlHeroes_VN_1.01_CCABNY26.apk">Tải về</a></h4>
	<?php	
		}
		if($id == 3){
			$models = array('N95','N76','6290','5700XM','6121c','6120c','N81','N82','E51','6124c','6110n','6110N','E66','N81 8GB','N95 8GB',' N95-3NAM','E90','6122C','5710XM','E61','E62','E61i','N77','5320XM','N78','6210N','6210n','6220c','N96','N79','N85 ','6650','6650F','6650f','6210S','6210s','E71','E63','E90C','E90c','N71','N92','E50','N93','N73','N75','N93I','N93i','E65','N80','E60','E70','3250 ','N91','N91','8GB','5500','5630');
			if(in_array($model, $models )){
					header('Location: store/mcvl/63/MCVL_s60v5.jar');
			}
			$models = array('N97 MINI','N97i','5800XM','5802XM','5530');
			if(in_array($model, $models )){
					header('Location: store/mcvl/63/MCVL_s60v3.jar');
			}
			$models = array('6267','6500S','6500s','7500','7900P','7900p','6555','5310XM','5610XM','6263','6301','5220XM','6212C','6212c','5000','6300i','3120c','2600c','6600S','6600s','6600F','6600f','3600S','3600s','6500C','6500c','7610S','7610s','7310S','7310s','7210S','7210s','1680C','1680c','7100S','7100s','5130XM','3610F','3610f','7210C','7210c','7212C','7212c','3602S','3602s','3610A','3610a','7310C','7310c','6165','6111','5200','6085','6086','6151','2865I','6136','6125','3110C','3500C','3109C','2630','2760','2660','2605','5208','3110E','2680S','7070P','3555','2323C','2330C','2330c','1680C','1680c','1681C','1681c','2320C','2320c','2228','7370','6280','6265I','6265i','6270','7390','6288','7373','5300','6131','6300','6133','6275I','6275','6126','6282','6233','6234','8600L','8600l','6131NFC','6131nfc','8208C','8208c','6131I','6131i');
			if(in_array($model, $models )){
					header('Location: store/mcvl/63/MCVL_s40v3.jar');
			}
			$models = array('K790C','S700C','W830c','K810i','M608c','M600i','W958c','W595c','W908C','C702','C902','C905','G502','G602','G705','K660','K770','K790','K800','K818','K858','K880','S500','T658','T700','W580','W595','W707','W760','W760','W830','W850','W888','W890','W898','W900','W902','W908','W980','Z750','Z770','Z780','G700','G702','G900','M600','M608','P1','P3','P5','P990','W950','W958','W960');
			if(in_array($model, $models )){
					header('Location: store/mcvl/63/MCVL_w910.jar');
			}
			
			?>
				<p>Hệ thống không xác định được dòng máy của bạn, bạn hãy chọn dòng máy phù hợp để tải về.</p>
				<h4>Dòng máy S60V3:</h4>
				Tải về: <a href="store/mcvl/63/MCVL_s60v5.jar">Jar</a> | <a href="store/mcvl/63/MCVL_s60v5.jad">Jad</a>
				<p>N95,N76,6290,5700XM,6121C,6120C,N81,N82,E51,6124C,6110N,E66,N81 8GB,N95 8GB,N95-3NAM,E90,6122C,5710XM,E61,E62,E61i,N77,5320XM,N78,6210N,6220C,N96,N79,N85 ,6650,6650F,6210S,E71,E63,E90C,N71,N92,E50,N93,N73,N75,N93I,E65,N80,E60,E70,3250 ,N91,N91,8GB,5500,5630</p>
				<h4>Dòng máy S60V5:</h4>
				Tải về: <a href="store/mcvl/63/MCVL_s60v3.jar">Jar</a> | <a href="store/mcvl/63/MCVL_s60v3.jad">Jad</a>
				<p>N97 MINI,N97i,5800XM,5802XM,5530</p>
				<h4>Dòng máy S40V3:</h4>
				Tải về: <a href="store/mcvl/63/MCVL_s40v3.jar">Jar</a> | <a href="store/mcvl/63/MCVL_s40v3.jad">Jad</a>
				<p>6267,6500S,7500,7900P,6555,5310XM,5610XM,6263,6301,5220XM,6212C,5000,6300i,3120c, 2600c,6600S,6600F,3600S,6500C,7610S,7310S,7210S,1680C,7100S,5130XM,3610F,7210C ,7212C,3602S,3610A,7310C,,6165,6111,5200,6085,6086,6151,2865I,6136,6125,3110C ,3500C,3109C,2630,2760,2660,2605,5208,3110E,2680S,7070P,3555,2323C,2330C,1680C ,1681C,2320C,2228,7370,6280,6265I,6270,7390,6288,7373,5300,6131,6300,6133,6275I ,6275,6126,6282,6233,6234,8600L,6131NFC,8208C,6131I</p>
				<h4>Dòng máy W910:</h4>
				Tải về: <a href="store/mcvl/63/MCVL_w910.jar">Jar</a> | <a href="store/mcvl/63/MCVL_w910.jad">Jad</a>
				<p>K790C ,S700C,W830c ,K810i,M608c,M600i,W958c,W595c ,W908C ,C702, C902, C905, G502, G602, G705, K660, K770, K790, K800, K818, K858, K880, S500, T658, T700, W580, W595, W707, W760, W760, W830, W850, W888, W890, W898, W900, W902, W908, W980, Z750, Z770, Z780, G700, G702, G900, M600, M608, P1, P3, P5, P990, W950, W958, W960</p>
				<h4>Dòng máy Cảm ứng:</h4>
				Tải về: <a href="store/mcvl/63/MCVL_etc2.jar">Jar</a> | <a href="store/mcvl/63/MCVL_etc2.jad">Jad</a>
				<h4>Dòng máy khác:</h4>
				Tải về: <a href="store/mcvl/63/MCVL_etc.jar">Jar</a> | <a href="store/mcvl/63/MCVL_etc.jad">Jad</a>			
				
			<?php
		}
		if($id == 4){
			if(strcasecmp($os, 'android') == 0){
				header('Location: store/truthan/61229/android/ZhuShen_android.apk');
			}
			if(strcasecmp($brand, 'nokia') == 0){
				$models = array('N73','N71','N75','N76','N77','N78','N79','N81','N82','N85','N92','N93','N93i','N95','N96','6110N','6120c','6121c','6122c','6124c','6210N','6211c','6220c','6290','6650','5320XM','5700XM','5710XM','E50','E51','E65','E66','6120ci','5630XM','5730XM','E52','E55','E75','5320diXM','6210si','6710N','6720c','6730c','N86','N80','N90','6700slide','6788');
				if(in_array($model, $models )){
						header('Location: store/truthan/61209/ZhuShen_YN_nkN73.jar');
				}
				
				$models = array('5800','5800i','5530','5802','5900','N97','5230','5325','X6');
				if(in_array($model, $models )){
						header('Location: store/truthan/61209/ZhuShen_YN_nk5800.jar');
				}
				
				$models = array('7610','N70','N72','3230','6260','6620','6600','6670');
				if(in_array($model, $models )){
						header('Location: store/truthan/61209/ZhuShen_YN_nk7610.jar');
				}
				
				$models = array('3602s','5300','5300XM','6126','6131','6131NFC','6133','6233','6234','6265','6265i','6270','6280','6282','6288','6300','6275i','7370','7373','7390','7612s','8600');
				if(in_array($model, $models )){
						header('Location: store/truthan/61209/ZhuShen_YN_nk7370.jar');
				}
				
				$models = array('X6','5228','5230','5233','5235','5250','5530','N5800','5800d','5800i','5800XM','5802XM','C6','C7','N8','N97','N97i','N97mini');
				if(in_array($model, $models )){
						header('Location: store/truthan/61209/ZhuShen_YN_nkX6.jar');
				}
				
				$models = array('E61','E61i','E62','E63','E71','E71x','E72','6790s','6760s');
				if(in_array($model, $models )){
						header('Location: store/truthan/61209/ZhuShen_YN_nkE62.jar');
				}
				
				$models = array('N5500','5500d');
				if(in_array($model, $models )){
						header('Location: store/truthan/61209/ZhuShen_YN_nkN5500.jar');
				}
			}
			if(strcasecmp($brand, 'SonyEricsson') == 0){
				$models = array('K790','K790c','W580c','W595c','W760c','W830i','W850','W850c','W850i','W880','W880i','W888c','W890i','W900','W900i','W902','W908c','W950i','W980c','W980i','K660i','K770c','K800c','K810i','K818c','K850','K850i','K858c','C702','C902','C905','G502','P990c','S500c','T658c','T700','Z750i','Z770','Z780','Z810i');
				if(in_array($model, $models )){
						header('Location: store/truthan/61209/ZhuShen_YN_seK790.jar');
				}
				
				$models = array('M608','M608c','M600','G700c','G702','G900','P1c','P3i','W958c','W960i');
				if(in_array($model, $models )){
						header('Location: store/truthan/61209/ZhuShen_YN_seM608.jar');
				}
			}
			if(strcasecmp($brand, 'Motorola') == 0){
				$models = array('E680','A1200','A1200E','A1208','A1600','A1800','A728','A760','A760i','A768','A768i','A780','A810','E6','E680g','E680i','E6e');
				if(in_array($model, $models )){
						header('Location: store/truthan/61209/ZhuShen_YN_mtE680.jar');
				}
				$models = array('E2','E3','U9','V6','V8','VE358','VE66','Z6','Z6w','Z9','ZN5','E1000','V3x');
				if(in_array($model, $models )){
						header('Location: store/truthan/61209/ZhuShen_YN_mtE2.jar');
				}
			}
			if(strcasecmp($brand, 'Samsung') == 0){
				$models = array('S3930C','B5702C','B5712c','C3050C','C3610C','C6112c','D608','D788','D808','D820','D828','D838','D848','D880','D888','D900','D908','D908i','D988','E2210C','E838','E840','E848','E848i','E898','E900','E908','E958','F488','F488E','G508E','G608','G618','G808','G808E','G818E','GT-S3930C','GT-S3930','i450','i458','i688(TD)','i728','i7110C','i8510C','J218','L258','L288(TD)','L878E','M3318','M3318C','M3510C','M7500C','P858','S3500C','S5050C','S5200C','S6700','SGH-i688','U308','U600','U608','U700','U708','U708E','U808E');
				if(in_array($model, $models )){
						header('Location: store/truthan/61209/ZhuShen_YN_seS3930C.jar');
				}
				////Miss SGH
				
				$models = array('U908E','U908e','U908');
				if(in_array($model, $models )){
						header('Location: store/truthan/61209/ZhuShen_YN_seU908E.jar');
				}
			}
			if(strcasecmp($brand, 'htc') == 0){
				$models = array('S1','686','696','818','828','830','838','900','A6188','C858','C858g','D600','D600CMCC','D802','D802CMCC','D805','E616','P660','P800','P860','S505','S600','S700','T2222','T3238','T3333','T4288');
				if(in_array($model, $models )){
						header('Location: store/truthan/61209/ZhuShen_YN_dpS1.jar');
				}
				$models = array('S900','S900c+','S910','S910W','S910w','U1000');
				if(in_array($model, $models )){
						header('Location: store/truthan/61209/ZhuShen_YN_dpS900.jar');
				}
			}
			?>
				<p>Hệ thống không xác định được dòng máy của bạn, bạn hãy chọn dòng máy phù hợp để tải về.</p>
				<h4>Nokia N73 (240*320)</h4>
				Tải về: <a href="store/truthan/61209/ZhuShen_YN_nkN73.jar">Jar</a> | <a href="store/truthan/61209/ZhuShen_YN_nkN73.jad">Jad</a>
				<p>N73, N71, N75, N76, N77, N78, N79, N81,N82,N85, N92, N93, N93i, N95, N96, 6110N, 6120c,6121c, 6122c, 6124c, 6210N, 6211c, 6220c, 6290, 6650, 5320XM, 5700XM,5710XM,E50, E51,E65, E66，6120ci，5630XM，5730XM， E52，E55，E75，5320diXM，6210si，6710N， 6720c，6730c，N86，N80，N90，6700 slide， 6788</p>
				
				<h4>Nokia 5800</h4>
				Tải về: <a href="store/truthan/61209/ZhuShen_YN_nk5800.jar">Jar</a> | <a href="store/truthan/61209/ZhuShen_YN_nk5800.jad">Jad</a>
				<p>5800，5800i，5530，5802，5900，N97， 5230，5325，X6</p>
				
				<h4>Nokia 7610 (176*208)</h4>
				Tải về: <a href="store/truthan/61209/ZhuShen_YN_nk7610.jar">Jar</a> | <a href="store/truthan/61209/ZhuShen_YN_nk7610.jad">Jad</a>
				<p>7610, N70, N72, 3230, 6260, 6620, 6600, 6670</p>
				
				<h4>Nokia 7370</h4>
				Tải về: <a href="store/truthan/61209/ZhuShen_YN_nk7370.jar">Jar</a> | <a href="store/truthan/61209/ZhuShen_YN_nk7370.jad">Jad</a>
				<p>3602s，5300,5300XM，6126,6131，6131 NFC,6133, 6233,6234,6265,6265i,6270,6280,6282,6288, 6300,6275i,7370，7373，7390,7612s，8600</p>
				
				<h4>Nokia X6 (360*360)</h4>
				Tải về: <a href="store/truthan/61209/ZhuShen_YN_nkX6.jar">Jar</a> | <a href="store/truthan/61209/ZhuShen_YN_nkX6.jad">Jad</a>
				<p>X6, 5228, 5230, 5233, 5235, 5250, 5530, N5800, 5800d, 5800i, 5800XM, 5802XM, C6, C7, N8, N97, N97i, N97mini</p>
			
				<h4>Nokia E62 (320*240)</h4>
				Tải về: <a href="store/truthan/61209/ZhuShen_YN_nkE62.jar">Jar</a> | <a href="store/truthan/61209/ZhuShen_YN_nkE62.jad">Jad</a>
				<p>E61, E61i, E62, E63, E71，E71x， E72，6790s，6760s</p>
				
				<h4>Nokia 5500 (208*208)</h4>
				Tải về: <a href="store/truthan/61209/ZhuShen_YN_nkN5500.jar">Jar</a> | <a href="store/truthan/61209/ZhuShen_YN_nkN5500.jad">Jad</a>
				<p>N5500,5500d</p>
				
				
				<h4>Sony Ericson K790C</h4>
				Tải về: <a href="store/truthan/61209/ZhuShen_YN_seK790.jar">Jar</a> | <a href="store/truthan/61209/ZhuShen_YN_seK790.jad">Jad</a>
				<p>K790c, W580c, W595c, W760c, W830i, W850, W850c, W850i, W880, W880i,W888c, W890i, W900, W900i,  W902, W908c, W950i, W980c, W980i, K660i, K770c, K800c, K810i, K818c, K850, K850i, K858c, C702, C902, C905, G502,	P990c, S500c, T658c, T700, Z750i, Z770, Z780, Z810i</p>
				
				<h4>Sony Ericson M608</h4>
				Tải về: <a href="store/truthan/61209/ZhuShen_YN_seM608.jar">Jar</a> | <a href="store/truthan/61209/ZhuShen_YN_seM608.jad">Jad</a>
				<p>M608c,M600,G700c,G702,G900,P1c,P3i,W958c,W960i</p>
				
				<h4>Motorola E680</h4>
				Tải về: <a href="store/truthan/61209/ZhuShen_YN_mtE680.jar">Jar</a> | <a href="store/truthan/61209/ZhuShen_YN_mtE680.jad">Jad</a>
				<p>E680, A1200, A1200E, A1208, A1600, A1800,  A728, A760, A760i, A768, A768i, A780, A810, E6, E680g, E680i, E6e</p>
				
				<h4>Motorola E2</h4>
				Tải về: <a href="store/truthan/61209/ZhuShen_YN_mtE2.jar">Jar</a> | <a href="store/truthan/61209/ZhuShen_YN_mtE2.jad">Jad</a>
				<p>E2, E3, U9, V6, V8, VE358, VE66, Z6, Z6w, Z9, ZN5，E1000，V3x</p>
				
				<h4>Samsung S3930C</h4>
				Tải về: <a href="store/truthan/61209/ZhuShen_YN_seS3930C.jar">Jar</a> | <a href="store/truthan/61209/ZhuShen_YN_seS3930C.jad">Jad</a>
				<p>S3930C, B5702C, B5712c, C3050C, C3610C, C6112c, D608, D788, D808, D820, D828, D838, D848, D880, D888, D900, D908, D908i, D988, E2210C, E838, E840, E848, E848i, E898, E900, E908, E958, F488, F488E, G508E, G608, G618, G808, G808E, G818E, GT-S3930C, GT-S3930, i450, i458, i688(TD), i728, i7110C, i8510C, J218, L258, L288(TD), L878E, M3318, M3318C, M3510C, M7500C, P858, S3500C, S5050C, S5200C, S6700, SGH-i688, U308, U600, U608, U700, U708, U708E, U808E</p>
				
				<h4>Samsung U908E</h4>
				Tải về: <a href="store/truthan/61209/ZhuShen_YN_seU908E.jar">Jar</a> | <a href="store/truthan/61209/ZhuShen_YN_seU908E.jad">Jad</a>
				<p>U908E,U908</p>
				
				<h4>HTC S1</h4>
				Tải về: <a href="store/truthan/61209/ZhuShen_YN_dpS1.jar">Jar</a> | <a href="store/truthan/61209/ZhuShen_YN_dpS1.jad">Jad</a>
				<p>S1, 686, 696, 818, 828, 830, 838, 900, A6188, C858, C858g, D600, D600CMCC, D802, D802CMCC, D805, E616, P660, P800, P860, S505, S600, S700, T2222, T3238, T3333, T4288</p>
				
				<h4>HTC S900</h4>
				Tải về: <a href="store/truthan/61209/ZhuShen_YN_dpS900.jar">Jar</a> | <a href="store/truthan/61209/ZhuShen_YN_dpS900.jad">Jad</a>
				<p>S900, S900c+, S910, S910W, U1000</p>
				
				<h4>Hệ điều hành Android: <a href="store/truthan/61229/android/ZhuShen_android.apk">Tải về</a></h4>
			<?php
		}
		if($id==5){
			if(strcasecmp($brand, 'nokia') == 0){
			}
			if(strcasecmp($brand, 'Samsung') == 0){
			
			}
			if(strcasecmp($brand, 'Motorola') == 0){
			}
			if(strcasecmp($brand, 'SonyEricsson') == 0){
			}
			if(strcasecmp($brand, 'htc') == 0){
			}
			?>
			<h4>Nokia S40 (240*320)</h4>
			Tải về: <a href="store/chienthan/aaa.jar">Jar</a> | <a href="store/chienthan/aaa.jad">Jad</a>
			<p>6267,6500S,7500,7900P,6555,5310XM,5610XM,6301,5220XM,6212C,6300i,3120c,6600F,3600S,6500C,7610S,7310S,7210S,5130XM,7210C,7310C,7390,6275I,6275,8600L,8208C,2710n,2730c,3710f,3720c,5130XM,5330,5330XM,5610XM,6303c,6303i,6350,6600i,6600s,6700c,7020,7500 prism,7510s,7900 prism,X3,6265,6265i</p>
			
			<h4>Nokia N97 (360*640)</h4>
			Tải về: <a href="store/chienthan/aaa.jar">Jar</a> | <a href="store/chienthan/aaa.jad">Jad</a>
			<p>X6, N97, C6, 5230, 5230XM, 5800XM</p>
			
			<h4>Nokia N81 (240*320)</h4>
			Tải về: <a href="store/chienthan/aaa.jar">Jar</a> | <a href="store/chienthan/aaa.jad">Jad</a>
			<p>N96, N95, N93i, N93, N92, N86, N85,N82, N81, N79, N78, N77, N76, E65,E66, E75, 6124C, 6210S, 6210SI,6650F, 6710N, 6730, 6790,5700XM</p>
			<h4>Nokia N73 (240*320)</h4>
			Tải về: <a href="store/chienthan/aaa.jar">Jar</a> | <a href="store/chienthan/aaa.jad">Jad</a>
			<p>N73, N71, E50, E51, E52, 7100S,6120C, 6122C, 6210N, 6220C, 6290,6650, 6720C, 5320XM</p>
			
			<h4>Nokia E62 (320*240)</h4>
			Tải về: <a href="store/chienthan/aaa.jar">Jar</a> | <a href="store/chienthan/aaa.jad">Jad</a>
			<p>E61, E61i, E62, E63, E71, E72, 6790S</p>
			
			
			
			<h4>Sony Ericsson U1 (360*640)</h4>
			Tải về: <a href="store/chienthan/aaa.jar">Jar</a> | <a href="store/chienthan/aaa.jad">Jad</a>
			<p>G819, U1, U100i, U5i, U8i </p>
			
			<h4>Sony Ericsson T707 (240*320)</h4>
			Tải về: <a href="store/chienthan/aaa.jar">Jar</a> | <a href="store/chienthan/aaa.jad">Jad</a>
			<p>C905, C902, C702, J20, K858, K880,S500C, T707, W508, W518a, W595CW705, W707, W715, W760, W888,W898, W902, W908, W980, W995</p>
			
			<h4>Sony Ericsson K818 (240*320)</h4>
			Tải về: <a href="store/chienthan/aaa.jar">Jar</a> | <a href="store/chienthan/aaa.jad">Jad</a>
			<p>K810i, K818, K850i, T658, W580,W830, W850, W890, W900, W910</p>
			
			<h4>Sony Ericsson Android 480*854</h4>
			Tải về: <a href="store/chienthan/aaa.jar">Jar</a> | <a href="store/chienthan/aaa.jad">Jad</a>
			<p>LT15i,ST18a,ST18i,X10,X10i,Xperia Neo MT15iXperia Play (C), Xperia Pro MK16i</p>
			
			<h4>Sony Ericsson Android 480*854</h4>
			Tải về: <a href="store/chienthan/aaa.jar">Jar</a> | <a href="store/chienthan/aaa.jad">Jad</a>
			<p>LT15i,ST18a,ST18i,X10,X10i,Xperia Neo MT15iXperia Play (C), Xperia Pro MK16i</p>
			
			
			<h4>Motorola V9 (240*320)</h4>
			Tải về: <a href="store/chienthan/aaa.jar">Jar</a> | <a href="store/chienthan/aaa.jad">Jad</a>
			<p>EM35, V9, VA76R, VE66, ZN300, ZN5</p>
			
			<h4>Motorola Android G2 480*800</h4>
			Tải về: <a href="store/chienthan/aaa.jar">Jar</a> | <a href="store/chienthan/aaa.jad">Jad</a>
			<p>Alpha, Sholes</p>
			
			<h4>Motorola Android-droid 480*854</h4>
			Tải về: <a href="store/chienthan/aaa.jar">Jar</a> | <a href="store/chienthan/aaa.jad">Jad</a>
			<p>Bravo, Defy, Droid 2, Droid X, MB520,MB810 (Shadow), ME525 (Defy),ME722 (Milestone2), Milestone,Milestone 2,XT711, XT800+,XT806,XT8061x </p>
			
			
			<h4>SamSung I400 (240*320)</h4>
			Tải về: <a href="store/chienthan/aaa.jar">Jar</a> | <a href="store/chienthan/aaa.jad">Jad</a>
			<p>C3518, G810, I400, I408, I450, I458I520, I550W, I560, I8510, I8910U,L870, L878E, i8510C</p>
			
			<h4>SamSung Android-G2 480*800</h4>
			Tải về: <a href="store/chienthan/aaa.jar">Jar</a> | <a href="store/chienthan/aaa.jad">Jad</a>
			<p>Continuum, Fascinate, Forte, GT I9000 (Galaxy S), GT I9088, Galaxy 2, Galaxy Neo M220L,Galaxy Prevail, Galaxy S 4G, Galaxy S M110S,Galaxy U SHW M130L, I809, I9000, I9001, I9003,I9010,I9023, I9100, I9103, I997, M100S, M190S,SCH i909, SK S100, T759 Exhibit 4G,Vibrant 4G, W899, i8520, i9008L,Armani Galaxy S, I9020A</p>
			
			<h4>HTC Java 240*320</h4>
			Tải về: <a href="store/chienthan/aaa.jar">Jar</a> | <a href="store/chienthan/aaa.jad">Jad</a>
			<p>LANCASTER</p>
			
			<h4>HTC Android - g2 480*800</h4>
			Tải về: <a href="store/chienthan/aaa.jar">Jar</a> | <a href="store/chienthan/aaa.jad">Jad</a>
			<p>myTouch 3G HD, Vision, ThunderBolt,Revolver, Panache, Mytouch4G,MyTouch, Marvel, Lexikon, Lead, Knight,Inspire4G,IncredibleHD,Incerdible 2,Incredible, G7, G5, G2, G11, Emerald,EVO 4G (Supersonic). EVO 4G, Double Shot,DesireS, DesireHD, Bliss, AQUA, A9188 </p>
			
			<h4>LG Java 240 * 320</h4>
			Tải về: <a href="store/chienthan/aaa.jar">Jar</a> | <a href="store/chienthan/aaa.jad">Jad</a>
			<p>KS360, KM710, KM380, KG90N, KH70c, KF600,KF510, KF350, KF300, KE608, KD877, KC550,GD330, GD310, GD300,BL20e</p>
			
			<h4>LG Android - g2 480*800</h4>
			Tải về: <a href="store/chienthan/aaa.jar">Jar</a> | <a href="store/chienthan/aaa.jad">Jad</a>
			<p>Revolution, P993, P970 (Optimus Black),Optimus2X, Optimus G2x, Optimus 3D,LU3000, Genesis</p>
			
			<h4>Android 480*854 Toshiba &amp; Sharp</h4>
			Tải về: <a href="store/chienthan/aaa.jar">Jar</a> | <a href="store/chienthan/aaa.jad">Jad</a>
			<p>T 01C, IS11T</p>			
			
			<h4>Android 480*800</h4>
			<p>ZTE: skate, V9e, V9, V8</p> 
			<p>DEC, Acer, OPPO: DEC SX30, Acer beTouch E400, OPPO X903</p> 
			<p>Huawei: X6, X5, IDEOS S7 Slim, C8800</p> 
			<p>Changhong: Z1</p> 
			<p>K-Touch: W700, E800</p> 
			<p>Pantech: Vega Racer, IS06</p> 
			<p>ASUS: T60</p> 
			<p>Lenovo: LePhone 3GC, LePhone</p> 
			<p>Sharp: Shiro, SH8168U, SH8158U, SH8138U, SH8128U,005SH, 004SH, 003SH</p> 
			<p>APANDA: A100</p> 
			<p>Google: Nexus One</p> 
			<p>Dell: mini 5</p> 
			<p>Aigo:A8</p> 
			
			Tải về: <a href="store/chienthan/aaa.jar">Jar</a> | <a href="store/chienthan/aaa.jad">Jad</a>
			<p>SH7318U, SH7228U, SH7218, IS05</p>
			
			<h4>Android 320*480 Huawei &amp; Coolpad</h4>
			Tải về: <a href="store/chienthan/aaa.jar">Jar</a> | <a href="store/chienthan/aaa.jad">Jad</a>
			<p>CHT8000, C8600, D530</p>	
			
			<h4>Android 640*960 Meizu</h4>
			Tải về: <a href="store/chienthan/aaa.jar">Jar</a> | <a href="store/chienthan/aaa.jad">Jad</a>
			<p>MX, M9 RE, M9</p>		
			<?php
		}
		break;
	case 'detail':
		$game_app = mysql_query("SELECT * FROM `gom_game_app` as `a` WHERE `a`.`id` = '" . $id . "'");
		echo '<tr height="8px;"><td colspan="2"></td></tr>';
		if (mysql_num_rows($game_app)) {
			while (($res = mysql_fetch_assoc($game_app)) !== false) {
				echo '<tr><td colspan="2" class="danhmuc">' . $res['name'] . '</td></tr>';
				echo '<tr height="8px;"><td colspan="2"></td></tr>';
				echo '<tr><td width="30%"><img src="'.$set['homeurl'].'/gameapp_files/' . $res_app['name'] . '/' . $res['logo'] . '" /></td>';
				echo '<td width="70%" valign="top"><a href="' . $set['homeurl'] . '/gamestore/index.php?src='.$src.'&amp;act=download&amp;id=' . $res['j2me_jad_file_path'] . '">Tải miễn phí</a><br /><br />' . $res['total_download'] . ' số lượt tải<br /><br />';
				echo '<a href="#">Thiết bị hỗ trợ</a><br /><br /><a href="#">Xem ảnh giới thiệu game</a></td></tr>';
				echo '<tr><td colspan="2" class="header-chitiet">Diễn đàn liên quan</td></tr>';
				echo '<tr><td colspan="2">Nội dung tin mới trong diễn đàn.</td></tr>';
				echo '<tr><td colspan="2" class="header-chitiet">Giới thiệu</td></tr>';
				echo '<tr><td colspan="2">' . $res['description'] . '</td></tr>';
			}
			echo '<tr><td colspan="2"><hr /></td></tr>';
			$cate_relation = mysql_query("SELECT `a`.`id`, `a`.`name` FROM `gom_the_loai` as `a` WHERE `a`.`id` IN (SELECT `b`.`the_loai_id` FROM `gom_the_loai_relation` as `b` WHERE `b`.`game_app_id` = ". $id .")");
			if (mysql_num_rows($cate_relation)) {
				while (($res_cate_relation = mysql_fetch_assoc($cate_relation)) !== false) {
					echo '<tr><td colspan="2" class="danhmuc">' . $res_cate_relation['name'] . '</td></tr>';
					echo '<tr height="8px;"><td colspan="2"></td></tr>';
					$str_query = "SELECT `b`.`id`, `b`.`logo`, `b`.`name`,
													       `b`.`j2me_jad_file_path`, `b`.`j2me_jar_file_path`, `b`.`android_apk_file_path`,
													       `b`.`short_decription` FROM `gom_the_loai_relation` as `a`
																				INNER JOIN `gom_game_app` as `b` ON `a`.`game_app_id` = `b`.`id`
																				INNER JOIN `gom_the_loai` as `c` ON `a`.`the_loai_id` = `c`.`id`
													 WHERE `c`.`id` = " . $res_cate_relation['id'] . " AND `b`.`id` != " . $id . " ORDER BY `b`.`last_update` LIMIT 5";
					$lst_game_app_top5 = mysql_query($str_query);
					while (($res_app_top5 = mysql_fetch_assoc($lst_game_app_top5)) !== false) {
						if(isset($res_app_top5['logo'])) {
							echo '<tr><td width="30%"><a href="'.$set['homeurl'].'/gamestore/index.php?src='.$src.'&amp;act=detail&amp;id='.$res_app_top5['id'].'"><img src="' . $set['homeurl'] . '/images/' . $res_app_top5['logo'] . '" /></a></td>';
							echo '<td width="70%" valign="top">' . $res_app_top5['name'] . '<br />' . $res_app_top5['j2me_jad_file_path'] . '<br />' . $res_app_top5['id'] . '<br /><div class="chitiet"><a href="'.$set['homeurl'].'/gamestore/index.php?src='.$src.'&amp;act=detail&amp;id='.$res_app_top5['id'].'">Chi tiết</a></div></td></tr>';
						} else {
							echo '<tr><td colspan="2" valign="top">' . $res_app_top5['name'] . '<br />' . $res_app_top5['j2me_jad_file_path'] . '<br />' . $res_app_top5['short_decription'] . '</td></tr>';
						}
						echo '<tr><td colspan="2"><hr /></td></tr>';
					}
				}
			}
		}
		break;
	case 'category':
		echo '<tr height="8px;"><td colspan="2"></td></tr>';
		$danhmuc = mysql_query("SELECT `a`.`name` FROM `gom_danh_muc` as `a` WHERE `a`.`id` = " . $id);
		if (mysql_num_rows($danhmuc)) {
			//max displayed per page
			$per_page = 9;
			// count records
			$count_record = mysql_num_rows(mysql_query("SELECT `a`.`id` FROM `gom_game_app` as `a` WHERE `a`.`danh_muc_id` = ".$id." ORDER BY `a`.`last_update`"));
			// count max pages
			$max_pages = ceil($count_record / $per_page);
			// current page
			if(isset($_GET['page']))
				$current_page = $_GET['page'];
			else
				$current_page = 1;
			while (($res_category = mysql_fetch_assoc($danhmuc)) !== false) {
				echo '<tr><td colspan="2" class="danhmuc">' . $res_category['name'] . '</td></tr>';
				echo '<tr height="8px;"><td colspan="2"></td></tr>';
				$lst_game_app_top9_in_danhmuc = mysql_query("SELECT `a`.`id`, `a`.`logo`, `a`.`name`, `a`.`j2me_jad_file_path`, 
																	 `a`.`j2me_jar_file_path`, `a`.`android_apk_file_path`, `a`.`short_decription`
																FROM `gom_game_app` as `a` 
												 					WHERE `a`.`danh_muc_id` = ".$id." ORDER BY `a`.`last_update` LIMIT ".$per_page*($current_page-1).", ".$per_page);
				if (mysql_num_rows($danhmuc)) {
					while (($res_game_app_top9 = mysql_fetch_assoc($lst_game_app_top9_in_danhmuc)) !== false) {
						if(isset($res_game_app_top9['logo'])) {
							echo '<tr><td width="30%"><a href="'.$set['homeurl'].'/gamestore/index.php?src='.$src.'&amp;act=detail&amp;id='.$res_game_app_top9['id'].'"><img src="' . $set['homeurl'] . '/images/' . $res_game_app_top9['logo'] . '" /></a></td>';
							echo '<td width="70%" valign="top">' . $res_game_app_top9['name'] . '<br />' . $res_game_app_top9['j2me_jad_file_path'] . '<br />' . $res_game_app_top9['short_decription'] . '<br /><div class="chitiet"><a href="'.$set['homeurl'].'/gamestore/index.php?src='.$src.'&amp;act=detail&amp;id='.$res_game_app_top9['id'].'">Chi tiết</a></div></td></tr>';
						} else {
							echo '<tr><td colspan="2" valign="top">' . $res_game_app_top9['name'] . '<br />' . $res_game_app_top9['j2me_jad_file_path'] . '<br />' . $res_game_app_top9['short_decription'] . '</td></tr>';
						}
						echo '<tr><td colspan="2"><hr /></td></tr>';
					}
				}
				/*
				-----------------------------------------------------------------
				Paging block
				-----------------------------------------------------------------
				*/
				echo '<tr><td colspan="2">Đến trang';
				for ($i=1; $i<=$max_pages; $i++) {
					if ($current_page!=$i)
						echo ' <a href="'.$set['homeurl'].'/gamestore/index.php?src='.$src.'&amp;act=category&amp;id='.$id.'&amp;page='.$i.'">'.$i.'</a> ';
					else
						echo " ".$i." " ;
				}
				echo '</td></tr>';
				echo '<tr><td colspan="2"><hr /></td></tr>';
			}
		}
		break;
	case 'search':
		$app_game_name = $_GET['app_game_name'];
		//max displayed per page
		$per_page = 9;
		// count records
		$count_record = mysql_num_rows(mysql_query("SELECT `a`.`id` FROM `gom_game_app` as `a` WHERE LOWER(`a`.`name`) LIKE '%".$app_game_name."%'"));
		// count max pages
		$max_pages = ceil($count_record / $per_page);
		// current page
		if(isset($_GET['page']))
			$current_page = $_GET['page'];
		else
			$current_page = 1;
		echo '<tr><td colspan="2" class="danhmuc">Danh mục game</td></tr>';
		$lst_result = mysql_query("SELECT `a`.`id`, `a`.`logo`, `a`.`name`,
									 	`a`.`j2me_jad_file_path`, `a`.`j2me_jar_file_path`, `a`.`android_apk_file_path`, `a`.`short_decription`
									 FROM `gom_game_app` as `a` WHERE LOWER(`a`.`name`) LIKE '%".$app_game_name."%'
									  ORDER BY `a`.`last_update` LIMIT ".$per_page*($current_page-1).", ".$per_page);
		if (mysql_num_rows($lst_result)) {
			while (($res = mysql_fetch_assoc($lst_result)) !== false) {
				if(isset($res['logo'])) {
					echo '<tr><td width="30%"><a href="'.$set['homeurl'].'/gamestore/index.php?src='.$src.'&amp;act=detail&amp;id='.$res['id'].'"><img src="' . $set['homeurl'] . '/images/' . $res['logo'] . '" /></a></td>';
					echo '<td width="70%" valign="top">' . $res['name'] . '<br />' . $res['j2me_jad_file_path'] . '<br />' . $res['short_decription'] . '<br /><div class="chitiet"><a href="'.$set['homeurl'].'/gamestore/index.php?src='.$src.'&amp;act=detail&amp;id='.$res['id'].'">Chi tiết</a></div></td></tr>';
				} else {
					echo '<tr><td colspan="2" valign="top">' . $res['name'] . '<br />' . $res['j2me_jad_file_path'] . '<br />' . $res['short_decription'] . '</td></tr>';
				}
				echo '<tr><td colspan="2"><hr /></td></tr>';
			}
		}
		/*
		 -----------------------------------------------------------------
		 Paging block
		 -----------------------------------------------------------------
		*/
		echo '<tr><td colspan="2">Đến trang';
		for ($i=1; $i<=$max_pages; $i++) {
			if ($current_page!=$i)
				echo ' <a href="'.$set['homeurl'].'/gamestore/index.php?act=search&amp;app_game_name='.$app_game_name.'&amp;page='.$i.'">'.$i.'</a> ';
			else
				echo " ".$i." " ;
		}
		echo '</td></tr>';
		echo '<tr><td colspan="2"><hr /></td></tr>';
		break;
	case 'advanced':
		$advanced_name = $_GET['advanced_name'];
		$advanced_danhmuc = $_GET['advanced_danhmuc'];
		$advanced_theloai = $_GET['advanced_theloai'];
		$sql_advanced = "SELECT `a`.`id`, `a`.`logo`, `a`.`name`,
								`a`.`j2me_jad_file_path`, `a`.`j2me_jar_file_path`, `a`.`android_apk_file_path`, `a`.`short_decription`
							FROM `gom_game_app` as `a` ";
		$where = "WHERE 1=1 ";
		$inner_join = " ";
		if(isset($advanced_name) && ($advanced_name != ''))
			$where = $where . "AND `a`.`name` LIKE '%".$advanced_name."%' ";
		if(isset($advanced_theloai) && ($advanced_theloai != '')) {
			$inner_join = " INNER JOIN `gom_the_loai_relation` as `b` ON `a`.`id` = `b`.`game_app_id` ";
			$where = $where . "AND `b`.`the_loai_id` = ".$advanced_theloai." ";
		}
		if(isset($advanced_danhmuc) && ($advanced_danhmuc != ''))
			$where = $where . "AND `a`.`danh_muc_id` = ".$advanced_danhmuc." ";
		
		//max displayed per page
		$per_page = 9;
		// count records
		$count_record = mysql_num_rows(mysql_query("SELECT `a`.`id` FROM `gom_game_app` as `a` ".$inner_join.$where));
		// count max pages
		$max_pages = ceil($count_record / $per_page);
		// current page
		if(isset($_GET['page']))
			$current_page = $_GET['page'];
		else
			$current_page = 1;
		
		$sql_advanced = $sql_advanced . $inner_join . $where." ORDER BY `a`.`last_update`LIMIT ".$per_page*($current_page-1).", ".$per_page;
		$lst_advanced = mysql_query($sql_advanced);
		echo '<tr><td colspan="2" class="danhmuc">Danh mục game</td></tr>';
		if (mysql_num_rows($lst_advanced)) {
			while (($res = mysql_fetch_assoc($lst_advanced)) !== false) {
				if(isset($res['logo'])) {
					echo '<tr><td width="30%"><a href="'.$set['homeurl'].'/gamestore/index.php?src='.$src.'&amp;act=detail&amp;id='.$res['id'].'"><img src="' . $set['homeurl'] . '/images/' . $res['logo'] . '" /></a></td>';
					echo '<td width="70%" valign="top">' . $res['name'] . '<br />' . $res['j2me_jad_file_path'] . '<br />' . $res['short_decription'] . '<br /><div class="chitiet"><a href="'.$set['homeurl'].'/gamestore/index.php?src='.$src.'&amp;act=detail&amp;id='.$res['id'].'">Chi tiết</a></div></td></tr>';
				} else {
					echo '<tr><td colspan="2" valign="top">' . $res['name'] . '<br />' . $res['j2me_jad_file_path'] . '<br />' . $res['short_decription'] . '</td></tr>';
				}
				echo '<tr><td colspan="2"><hr /></td></tr>';
			}
			/*
			 -----------------------------------------------------------------
			Paging block
			-----------------------------------------------------------------
			*/
			echo '<tr><td colspan="2">Đến trang';
			for ($i=1; $i<=$max_pages; $i++) {
				if ($current_page!=$i)
					echo ' <a href="'.$set['homeurl'].'/gamestore/index.php?act=advanced&amp;advanced_name='.$advanced_name.'&amp;advanced_danhmuc='.$advanced_danhmuc.'&amp;advanced_theloai='.$advanced_theloai.'&amp;page='.$i.'">'.$i.'</a> ';
				else
					echo " ".$i." " ;
			}
			echo '</td></tr>';
			echo '<tr><td colspan="2"><hr /></td></tr>';
		}
		break;
	case 'topdownload':
		//max displayed per page
		$per_page = 9;
		// count records
		$count_record = mysql_num_rows(mysql_query("SELECT `a`.`id` FROM `gom_game_app` as `a` ORDER BY `a`.`total_download` DESC"));
		// count max pages
		$max_pages = ceil($count_record / $per_page);
		// current page
		if(isset($_GET['page']))
			$current_page = $_GET['page'];
		else
			$current_page = 1;
		echo '<tr><td colspan="2" class="danhmuc">Top download</td></tr>';
		$lst_result = mysql_query("SELECT `a`.`id`, `a`.`logo`, `a`.`name`,
									 	`a`.`j2me_jad_file_path`, `a`.`j2me_jar_file_path`, `a`.`android_apk_file_path`, `a`.`short_decription`
									 FROM `gom_game_app` as `a` ORDER BY `a`.`total_download` DESC LIMIT ".$per_page*($current_page-1).", ".$per_page);
		if (mysql_num_rows($lst_result)) {
			while (($res = mysql_fetch_assoc($lst_result)) !== false) {
				if(isset($res['logo'])) {
					echo '<tr><td width="30%"><a href="'.$set['homeurl'].'/gamestore/index.php?src='.$src.'&amp;act=detail&amp;id='.$res['id'].'"><img src="' . $set['homeurl'] . '/images/' . $res_game_app_top9['logo'] . '" /></a></td>';
					echo '<td width="70%" valign="top">' . $res['name'] . '<br />' . $res['j2me_jad_file_path'] . '<br />' . $res['short_decription'] . '<br /><div class="chitiet"><a href="'.$set['homeurl'].'/gamestore/index.php?src='.$src.'&amp;act=detail&amp;id='.$res['id'].'">Chi tiết</a></div></td></tr>';
				} else {
					echo '<tr><td colspan="2" valign="top">' . $res['name'] . '<br />' . $res['j2me_jad_file_path'] . '<br />' . $res['short_decription'] . '</td></tr>';
				}
				echo '<tr><td colspan="2"><hr /></td></tr>';
			}
		}
		/*
		 -----------------------------------------------------------------
		Paging block
		-----------------------------------------------------------------
		*/
		echo '<tr><td colspan="2">Đến trang';
		for ($i=1; $i<=$max_pages; $i++) {
			if ($current_page!=$i)
				echo ' <a href="'.$set['homeurl'].'/gamestore/index.php?act=topdownload&amp;page='.$i.'">'.$i.'</a> ';
			else
				echo " ".$i." " ;
		}
		echo '</td></tr>';
		echo '<tr><td colspan="2"><hr /></td></tr>';
		break;
	default: echo '<tr><td colspan="2">No match action</td></tr>';
}

require('../incfiles/end.php');
?>