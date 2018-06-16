<!-- Slider -->
<div class="slider">
	<div class="callbacks_container">
		<ul class="rslides" id="slider">
			<li>
				<div class="w3layouts-banner-top w3layouts-banner-top1">
					<div class="container">
						<div class="slider-info">
							<h3>タイトル１</h3>
							<h4>メッセージ１</h4>
						</div>
					</div>
				</div>
			</li>
			<li>
				<div class="w3layouts-banner-top">
					<div class="container">
						<div class="slider-info">
							<h3>タイトル２</h3>
							<h4>メッセージ２</h4>
						</div>
					</div>
				</div>
			</li>
			<li>
				<div class="w3layouts-banner-top w3layouts-banner-top2">
					<div class="container">
						<div class="slider-info">
							<h3>タイトル３</h3>
							<h4>メッセージ３</h4>
						</div>
					</div>
				</div>
			</li>
		</ul>
	</div>
	<div class="clearfix"></div>
</div>
<!-- //Slider -->
<!--about-->
<div class="about">
	<div class="container">
		<div class="about-main">
			<div class="col-md-6 about-left_w3ls_img">
				<div class="about-left1_w3ls_img">
				
				</div>
			</div>
			<div class="col-md-6 about-right_w3ls">
				<div class="about-top_agile_its">
					<h3>[社内共有ツール]について</h3>
					<h5>新たなものを作り出すための知見共有サービス</h5>
					<p>社内の共有ツールについての説明を入れます。</p>
				</div>
			</div>
	   <div class="clearfix"> </div>
    </div> 
</div>
</div>
<!-- //about -->
<!-- welcome -->
<div class="welcome all_pad wthree">
	<div class="container">
		<h3 class="title">Welcome To [社内ツール]<span></span></h3>
		<div class="wel-grids">
			<div class="col-md-6 wel-grid-one bor_one text-center wow bounceInUp" data-wow-duration="1.5s" data-wow-delay="0s">
				<div class="wel-img">
					<i class="fa fa-database" aria-hidden="true"></i>
				</div>
				<h4>知見を貯める</h4>
				<p>知見を貯めることで同じ失敗を防ぎ、<br />お客様により良い体験を届ける</p>
			</div>
			<div class="col-md-6 wel-grid-one bor_two text-center wow bounceInUp" data-wow-duration="1.5s" data-wow-delay="0.1s">
				<div class="wel-img">
					<i class="fa fa-group icon" aria-hidden="true"></i>
				</div>
				<h4>社内 only</h4>
				<p>社内でのみ使うことができ、<br />情報は全て社外秘とするため、扱いに気をつけること</p>
			</div>
			<div class="col-md-6 wel-grid-one bor_three text-center wow bounceInUp" data-wow-duration="1.5s" data-wow-delay="0.2s">
				<div class="wel-img">
					<i class="fa fa-external-link" aria-hidden="true"></i>
				</div>
				<h4>良い知見には賛辞を</h4>
				<p>良い知見だと思うものはツール内だけでなく、<br />共有を行うことでより知見を浸透させていく</p>
			</div>
			<div class="col-md-6 wel-grid-one bor_four text-center wow bounceInUp" data-wow-duration="1.5s" data-wow-delay="0.3s">
				<div class="wel-img">
					<i class="fa fa-briefcase icon" aria-hidden="true"></i>
				</div>
				<h4>活用</h4>
				<p>知見を貯めるだけでは意味がない。<br />徹底的に活用することを意識すること</p>
			</div>
			<div class="clearfix"></div>
			
		</div>
	</div>
</div>

<script src="app/assets/js/jquery-2.1.4.min.js"></script>
<script src="app/assets/js/bootstrap.js"></script> <!-- Necessary-JavaScript-File-For-Bootstrap --> 
<script src="app/assets/js/responsiveslides.min.js"></script>
<script>
	$(function () {
		$("#slider").responsiveSlides({
			auto: true,
			pager:false,
			nav: true,
			speed: 1000,
			namespace: "callbacks",
			before: function () {
				$('.events').append("<li>before event fired.</li>");
			},
			after: function () {
				$('.events').append("<li>after event fired.</li>");
			}
		});
	});
</script>