<?php
	$offset = 0;
	$fp = fopen("proteinNames.txt","w");
	while($offset < 26000){
		$content = file_get_contents("https://www.uniprot.org/uniprot/?query=secondary+annotation%3a(type%3asecstruct)&columns=id%2centry+name%2creviewed%2cprotein+names%2cgenes%2corganism%2clength&offset=$offset&sort=score");
		if(preg_match_all("@\bSecondary structure\b@",$content) or preg_match_all("@\bsecondary structure\b@",$content)){
			preg_match_all("@<td class=\"entryID\"><a href=\"(.*)\">.*</a><\/td>@U", $content, $result);
			foreach($result[1] as $x=>$y){	// $y = uniprot/..
				$asl_y = explode("/", $y)[2];
				fwrite($fp, $asl_y."\n");
			}
		}
		$offset += 25;
	}
	fclose($fp);
?>