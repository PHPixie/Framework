<!DOCTYPE html>
<html>
	<head>
		<title>Error</title>
		<style>
			html{
				width:100%;
				min-height:100%;
				font-family:'Verdana';
				font-size:14px;
			}
			body{

				min-height:100%;
				background: #a90329; /* Old browsers */
				background: -moz-radial-gradient(center, ellipse cover, #a90329 0%, #6d0019 100%); /* FF3.6+ */
				background: -webkit-radial-gradient(center, ellipse cover, #a90329 0%,#6d0019 100%); /* Chrome10+,Safari5.1+ */
			}
			#content{
				max-width:80%;
				min-width:1000px;
				margin:auto;
				padding:10px 0px;
				background:#eee;
			}
			.file{
				font-weight:bold;
			}
			.block{
				border-bottom:1px solid #000;
				margin:10px;
			}
			.code{
				overflow: auto;
				padding:10px;
			}
			.highlight{
				background:#efecd0;
			}
			#exception{
				font-size:25px;
				font-weight:bold;
				padding:10px;
			}
			#debug{
				border-bottom: 1px solid black;
				margin: 10px;
			}
			#log{
				font-size:15px;
				font-weight:bold;
				padding:5px;
			}
			.log{
				padding:10px;
				border-bottom: 1px solid black;
			}
			.log.odd{
				
			}
			pre{
				margin:0px;
			}
			.thick{
				border-width:2px;
			}
		</style>
	</head>
	<body>
		<div id="content">
			<div id="exception"><?=$_($exception->getMessage());?></div>
			<div id="blocks">
				<?php foreach($trace->elements() as $key => $element):	?>
					<div class="block">
						<div class="file"><?=$_($element->location())?></div>
						<div class="code">
							<?php 
                                $offsets = $element->getNeighboringOffsets(7);
                                $pad = strlen($element->line(end($offsets)));
                                foreach($offsets as $key => $offset):
                                    if($offset !== 0) {
                                        $prefix = $element->line($offset);
                                        $prefix = str_pad($prefix, $pad);
                                    }else{
                                        $prefix = str_pad('', $pad, '>');
                                    }
                                    
                                ?>
							    <pre class="line <?php echo $offset==0?'highlight':''; ?>"><?php
                                     echo $_($prefix.'    '.$element->lineContents($offset));
                                ?></pre>
                                <?php endforeach;?>
						</div>
					</div>
					<?php 
						$items = $logger->items();
						if(!empty($items)):
					?>
						<div id="debug">
							<div id="log">Logged values:</div>
							<?php foreach($items as $key => $item):?>
								<div class="log">
        						<div class="file"><?=$_($item->traceElement()->location())?></div>

									<pre><?php
                                        echo $_($item->valueDump());
                                    ?></pre>
								</div>
							<?php endforeach;?>
						</div>
					<?php endif;?>
				<?php endforeach;?>
			</div>
		</div>
	</body>
</html>
