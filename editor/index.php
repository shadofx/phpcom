<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta http-equiv="X-UA-Compatible" content="ie=edge" />
		<title>Editor</title>
		<link rel="stylesheet" href="editor/style.css" />
	</head>
	<body>
		<?php
			$path = $_GET["path"];
			$file = $_GET["file"];
			if(!$path && !$file)
				$path = '..';
			if($path){
				$files = scandir($path, SCANDIR_SORT_ASCENDING);
				$home = realpath(join(DIRECTORY_SEPARATOR,[dirname(__FILE__),'..']));
				foreach ($files as $key => $value) {
					if($value === '.')
						continue;
					$fullpath = realpath(join(DIRECTORY_SEPARATOR,[$path,$value]));
					if (strpos($fullpath, $home) === 0) 
						$filepath = trim(substr($fullpath, strlen($home)),DIRECTORY_SEPARATOR);
					else
						continue;
					$filepath = $filepath ? join(DIRECTORY_SEPARATOR,['..',$filepath]) : '..';
					if(is_file($filepath)){
						?>
						<a href="editor?path=<?=$path?>&file=<?=$filepath?>"><?=$filepath?></a>
						<?php
					}else{
						?>
							<a href="editor?path=<?=$filepath?>"><?=$filepath?></a>
						<?php
					}
					?>
					<br/>
					<?php
				}
			}
			?>
			<hr/>
			<?php
			if($file){
				$contents = file_get_contents($file);
				$contents = str_replace("\n","<br/>",$contents);
				$contents = str_replace("\t","&emsp;",$contents);
				echo $contents;
			}
		?>
	</body>
</html>
