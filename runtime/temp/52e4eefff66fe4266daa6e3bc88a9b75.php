<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:43:"public/static/advTemplate/tileTemplate.html";i:1566522957;}*/ ?>
<style type="text/css">
	.<?php echo $rand_str; ?>-item{ width: 100%;height: 100%;flex: 1; }
	.<?php echo $rand_str; ?>-item a{ display: block; width: 100%;height: 100%; }
	.<?php echo $rand_str; ?>-item a img{ display: block;width: 100%;height: 100%; }
	div[class^='layout']{ width: 100%;height:100%;display: flex; }
	/* 一行一个  一行两个  一行三个  一行四个*/
	.layout-zero .<?php echo $rand_str; ?>-item,.layout-one .<?php echo $rand_str; ?>-item,.layout-two .<?php echo $rand_str; ?>-item,.layout-three .<?php echo $rand_str; ?>-item{ flex: 1; }
	/* 两左两右 */
	.layout-four{ flex-wrap: wrap; }
	.layout-four .<?php echo $rand_str; ?>-item{ flex-basis: 50%;height: 50%; }
	/* 一左两右 */
	.layout-five .<?php echo $rand_str; ?>-right .<?php echo $rand_str; ?>-item{ height: 50%; }
	/* 一上两下 */
	.layout-six{ flex-wrap: wrap; }
	.layout-six .<?php echo $rand_str; ?>-top,.layout-six .<?php echo $rand_str; ?>-buttom{width: 100%;height: 50%;}
	.layout-six .<?php echo $rand_str; ?>-buttom{ display: flex; }
	/* 一左三右 */
	.layout-seven .left,.layout-seven .<?php echo $rand_str; ?>-right{width: 50%;}
	.layout-seven .<?php echo $rand_str; ?>-right .<?php echo $rand_str; ?>-top,.layout-seven .<?php echo $rand_str; ?>-right .<?php echo $rand_str; ?>-buttom{width: 100%;height: 50%;}
	.layout-seven .<?php echo $rand_str; ?>-right .<?php echo $rand_str; ?>-buttom{flex-wrap: nowrap;}
	.layout-seven .<?php echo $rand_str; ?>-right .<?php echo $rand_str; ?>-buttom .<?php echo $rand_str; ?>-item{width: 50%;float: left;}

	<?php if($info['type'] == 1): ?>
	.adv-container-<?php echo $rand_str; ?>{display: inline-block;width: <?php echo $info['ap_width']; ?>px;height: <?php echo $info['ap_height']; ?>px;}
	<?php else: ?>
	.adv-container-<?php echo $rand_str; ?>{width: 100%;position: relative;}
	.adv-container-<?php echo $rand_str; ?>:before{content: '';padding-top: 50%;display: block;}
	.adv-container-<?php echo $rand_str; ?> > div {position: absolute;width: 100%;height: 100%;top: 0;left: 0;}
	<?php endif; ?>
</style>
<div class="adv-container-<?php echo $rand_str; ?>">
	<?php switch($info['layout']): case "1": ?>
			<!-- 一行一个 -->
			<div class="layout-zero">
				<div class="<?php echo $rand_str; ?>-item" style="width: 100%;height: 100%;">
					<?php if(is_url($info['advs'][0]['adv_url'])): ?>
						<a href="<?php echo $info['advs'][0]['adv_url']; ?>"  target="_blank">
					<?php else: if($info['type'] == 1): ?>
						<a href="<?php echo __URL('http://111.231.202.42:80/index.php'.$info['advs'][0]['adv_url']); ?>"  target="_blank">
						<?php else: ?>
						<a href="<?php echo __URL('http://111.231.202.42:80/index.php/wap'.$info['advs'][0]['adv_url']); ?>"  target="_blank">
						<?php endif; endif; ?>
						<img src="<?php echo __IMG($info['advs'][0]['adv_image']); ?>">
					</a>
				</div>
			</div>
		<?php break; case "2": ?>
			<!-- 一行两个 -->
			<div class="layout-one">
				<?php $__FOR_START_1885324151__=0;$__FOR_END_1885324151__=2;for($i=$__FOR_START_1885324151__;$i < $__FOR_END_1885324151__;$i+=1){ ?>
				<div class="<?php echo $rand_str; ?>-item">
					<?php if(is_url($info['advs'][$i]['adv_url'])): ?>
						<a href="<?php echo $info['advs'][$i]['adv_url']; ?>"  target="_blank">
					<?php else: if($info['type'] == 1): ?>
						<a href="<?php echo __URL('http://111.231.202.42:80/index.php'.$info['advs'][$i]['adv_url']); ?>"  target="_blank">
						<?php else: ?>
						<a href="<?php echo __URL('http://111.231.202.42:80/index.php/wap'.$info['advs'][$i]['adv_url']); ?>"  target="_blank">
						<?php endif; endif; ?>
						<img src="<?php echo __IMG($info['advs'][$i]['adv_image']); ?>">
					</a>
				</div>
				<?php } ?>
			</div>
		<?php break; case "3": ?>
			<!-- 一行三个 -->
			<div class="layout-two">
				<?php $__FOR_START_322614109__=0;$__FOR_END_322614109__=3;for($i=$__FOR_START_322614109__;$i < $__FOR_END_322614109__;$i+=1){ ?>
				<div class="<?php echo $rand_str; ?>-item">
					<?php if(is_url($info['advs'][$i]['adv_url'])): ?>
						<a href="<?php echo $info['advs'][$i]['adv_url']; ?>"  target="_blank">
					<?php else: if($info['type'] == 1): ?>
						<a href="<?php echo __URL('http://111.231.202.42:80/index.php'.$info['advs'][$i]['adv_url']); ?>"  target="_blank">
						<?php else: ?>
						<a href="<?php echo __URL('http://111.231.202.42:80/index.php/wap'.$info['advs'][$i]['adv_url']); ?>"  target="_blank">
						<?php endif; endif; ?>
						<img src="<?php echo __IMG($info['advs'][$i]['adv_image']); ?>">
					</a>
				</div>
				<?php } ?>
			</div>
		<?php break; case "4": ?>
			<!-- 一行四个 -->
			<div class="layout-three">
				<?php $__FOR_START_765659439__=0;$__FOR_END_765659439__=4;for($i=$__FOR_START_765659439__;$i < $__FOR_END_765659439__;$i+=1){ ?>
				<div class="<?php echo $rand_str; ?>-item">
					<?php if(is_url($info['advs'][$i]['adv_url'])): ?>
						<a href="<?php echo $info['advs'][$i]['adv_url']; ?>"  target="_blank">
					<?php else: if($info['type'] == 1): ?>
						<a href="<?php echo __URL('http://111.231.202.42:80/index.php'.$info['advs'][$i]['adv_url']); ?>"  target="_blank">
						<?php else: ?>
						<a href="<?php echo __URL('http://111.231.202.42:80/index.php/wap'.$info['advs'][$i]['adv_url']); ?>"  target="_blank">
						<?php endif; endif; ?>
						<img src="<?php echo __IMG($info['advs'][$i]['adv_image']); ?>">
					</a>
				</div>
				<?php } ?>
			</div>
		<?php break; case "5": ?>
			<!-- 两左两右 -->
			<div class="layout-four">
				<?php if(is_array($info['advs']) || $info['advs'] instanceof \think\Collection || $info['advs'] instanceof \think\Paginator): if( count($info['advs'])==0 ) : echo "" ;else: foreach($info['advs'] as $key=>$vo): ?>
				<div class="<?php echo $rand_str; ?>-item">
					<?php if(is_url($vo['adv_url'])): ?>
						<a href="<?php echo $vo['adv_url']; ?>"  target="_blank">
					<?php else: if($info['type'] == 1): ?>
						<a href="<?php echo __URL('http://111.231.202.42:80/index.php'.$vo['adv_url']); ?>"  target="_blank">
						<?php else: ?>
						<a href="<?php echo __URL('http://111.231.202.42:80/index.php/wap'.$vo['adv_url']); ?>"  target="_blank">
						<?php endif; endif; ?>
						<img src="<?php echo __IMG($vo['adv_image']); ?>">
					</a>
				</div>
				<?php endforeach; endif; else: echo "" ;endif; ?>
			</div>
		<?php break; case "6": ?>
			<!-- 一左两右 -->
			<div class="layout-five">
				<div class="left">
					<div class="<?php echo $rand_str; ?>-item">
						<?php if(is_url($info['advs'][0]['adv_url'])): ?>
							<a href="<?php echo $info['advs'][0]['adv_url']; ?>"  target="_blank">
						<?php else: if($info['type'] == 1): ?>
							<a href="<?php echo __URL('http://111.231.202.42:80/index.php'.$info['advs'][0]['adv_url']); ?>"  target="_blank">
							<?php else: ?>
							<a href="<?php echo __URL('http://111.231.202.42:80/index.php/wap'.$info['advs'][0]['adv_url']); ?>"  target="_blank">
							<?php endif; endif; ?>
							<img src="<?php echo __IMG($info['advs'][0]['adv_image']); ?>">
						</a>
					</div>
				</div>
				<div class="<?php echo $rand_str; ?>-right">
					<?php $__FOR_START_1206440184__=1;$__FOR_END_1206440184__=3;for($i=$__FOR_START_1206440184__;$i < $__FOR_END_1206440184__;$i+=1){ ?>
					<div class="<?php echo $rand_str; ?>-item">
						<?php if(is_url($info['advs'][$i]['adv_url'])): ?>
							<a href="<?php echo $info['advs'][$i]['adv_url']; ?>"  target="_blank">
						<?php else: if($info['type'] == 1): ?>
							<a href="<?php echo __URL('http://111.231.202.42:80/index.php'.$info['advs'][$i]['adv_url']); ?>"  target="_blank">
							<?php else: ?>
							<a href="<?php echo __URL('http://111.231.202.42:80/index.php/wap'.$info['advs'][$i]['adv_url']); ?>"  target="_blank">
							<?php endif; endif; ?>
							<img src="<?php echo __IMG($info['advs'][$i]['adv_image']); ?>">
						</a>
					</div>
					<?php } ?>
				</div>
			</div>
		<?php break; case "7": ?>
			<!-- 一上两下 -->
			<div class="layout-six">
				<div class="<?php echo $rand_str; ?>-top">
					<div class="<?php echo $rand_str; ?>-item">
						<?php if(is_url($info['advs'][0]['adv_url'])): ?>
							<a href="<?php echo $info['advs'][0]['adv_url']; ?>"  target="_blank">
						<?php else: if($info['type'] == 1): ?>
							<a href="<?php echo __URL('http://111.231.202.42:80/index.php'.$info['advs'][0]['adv_url']); ?>"  target="_blank">
							<?php else: ?>
							<a href="<?php echo __URL('http://111.231.202.42:80/index.php/wap'.$info['advs'][0]['adv_url']); ?>"  target="_blank">
							<?php endif; endif; ?>
							<img src="<?php echo __IMG($info['advs'][0]['adv_image']); ?>">
						</a>
					</div>
				</div>
				<div class="<?php echo $rand_str; ?>-buttom">
					<?php $__FOR_START_757399368__=1;$__FOR_END_757399368__=3;for($i=$__FOR_START_757399368__;$i < $__FOR_END_757399368__;$i+=1){ ?>
					<div class="<?php echo $rand_str; ?>-item">
						<?php if(is_url($info['advs'][$i]['adv_url'])): ?>
							<a href="<?php echo $info['advs'][$i]['adv_url']; ?>"  target="_blank">
						<?php else: if($info['type'] == 1): ?>
							<a href="<?php echo __URL('http://111.231.202.42:80/index.php'.$info['advs'][$i]['adv_url']); ?>"  target="_blank">
							<?php else: ?>
							<a href="<?php echo __URL('http://111.231.202.42:80/index.php/wap'.$info['advs'][$i]['adv_url']); ?>"  target="_blank">
							<?php endif; endif; ?>
							<img src="<?php echo __IMG($info['advs'][$i]['adv_image']); ?>">
						</a>
					</div>
					<?php } ?>
				</div>
			</div>
		<?php break; case "8": ?>
			<!-- 一左三右 -->
			<div class="layout-seven">
				<div class="left">
					<div class="<?php echo $rand_str; ?>-item">
						<?php if(is_url($info['advs'][0]['adv_url'])): ?>
							<a href="<?php echo $info['advs'][0]['adv_url']; ?>"  target="_blank">
						<?php else: if($info['type'] == 1): ?>
							<a href="<?php echo __URL('http://111.231.202.42:80/index.php'.$info['advs'][0]['adv_url']); ?>"  target="_blank">
							<?php else: ?>
							<a href="<?php echo __URL('http://111.231.202.42:80/index.php/wap'.$info['advs'][0]['adv_url']); ?>"  target="_blank">
							<?php endif; endif; ?>
							<img src="<?php echo __IMG($info['advs'][0]['adv_image']); ?>">
						</a>
					</div>
				</div>
				<div class="<?php echo $rand_str; ?>-right">
					<div class="<?php echo $rand_str; ?>-top">
						<div class="<?php echo $rand_str; ?>-item">
							<?php if(is_url($info['advs'][1]['adv_url'])): ?>
								<a href="<?php echo $info['advs'][1]['adv_url']; ?>"  target="_blank">
							<?php else: if($info['type'] == 1): ?>
								<a href="<?php echo __URL('http://111.231.202.42:80/index.php'.$info['advs'][1]['adv_url']); ?>"  target="_blank">
								<?php else: ?>
								<a href="<?php echo __URL('http://111.231.202.42:80/index.php/wap'.$info['advs'][1]['adv_url']); ?>"  target="_blank">
								<?php endif; endif; ?>
								<img src="<?php echo __IMG($info['advs'][1]['adv_image']); ?>">
							</a>
						</div>
					</div>
					<div class="<?php echo $rand_str; ?>-buttom">
						<?php $__FOR_START_1968548346__=2;$__FOR_END_1968548346__=4;for($i=$__FOR_START_1968548346__;$i < $__FOR_END_1968548346__;$i+=1){ ?>
						<div class="<?php echo $rand_str; ?>-item">
							<?php if(is_url($info['advs'][$i]['adv_url'])): ?>
								<a href="<?php echo $info['advs'][$i]['adv_url']; ?>"  target="_blank">
							<?php else: if($info['type'] == 1): ?>
								<a href="<?php echo __URL('http://111.231.202.42:80/index.php'.$info['advs'][$i]['adv_url']); ?>"  target="_blank">
								<?php else: ?>
								<a href="<?php echo __URL('http://111.231.202.42:80/index.php/wap'.$info['advs'][$i]['adv_url']); ?>"  target="_blank">
								<?php endif; endif; ?>
								<img src="<?php echo __IMG($info['advs'][$i]['adv_image']); ?>">
							</a>
						</div>
						<?php } ?>
					</div>
				</div>
			</div>
		<?php break; endswitch; ?>
</div>