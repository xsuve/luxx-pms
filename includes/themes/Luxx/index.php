<!-- Navbar -->
<div class="container-fluid navbar-c b-primary">
	<div class="v-middle">
		<div class="row">
			<div class="col-lg-2">
				<a href="<?php echo URL; ?>">
					<div class="navbar-c-logo">
						<img src="<?php echo URL; ?>includes/themes/<?php echo THEME; ?>/img/luxx-logo-white.svg" class="v-middle">
					</div>
				</a>
			</div>
			<div class="col-lg-8">
				<div class="navbar-c-links text-right v-middle">
					<a href="#home" class="text c-white">Home</a>
					<a href="#product" class="text c-white">Product</a>
					<a href="#modules" class="text c-white">Modules</a>
					<a href="#feedback" class="text c-white">Feedback</a>
					<a href="<?php echo URL; ?>login" class="text c-white">Get Started</a>
				</div>
			</div>
			<div class="col-lg-2">
				<div class="navbar-c-button text-right v-middle">
					<a href="https://codecanyon.net/item/luxx-clients-projects-and-invoices-management-platform/22612310?ref=mouple" target="_blank"><button class="btn b-secondary c-primary">Buy Luxx</button></a>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Header -->
<div class="container-fluid header b-primary" id="home">
	<div class="v-middle">
		<div class="row">
			<div class="col-lg-12 text-center">
				<h1 class="header-title c-white m-bottom-20">Take your business to the next level with Luxx</h1>
				<div class="header-text text c-white">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</div>
				<div class="header-button m-top-50">
					<a href="<?php echo URL; ?>login" class="m-right-10">
						<button class="btn b-yellow c-white">Get Started</button>
					</a>
					<a href="#" class="m-left-10">
						<button class="btn b-secondary c-primary">Read More</button>
					</a>
				</div>
			</div>
		</div>
	</div>
	<div class="header-boxes">
		<!-- Contact Box -->
		<div class="box b-white contact-box">
			<div class="p-all-30 text-center">
				<div class="contact-image-big">
					<img src="<?php echo URL; ?>includes/themes/<?php echo THEME; ?>/img/1.png" class="v-middle">
				</div>
				<h4 class="contact-name c-title m-top-20">John Doe</h4>
				<div class="category m-top-10 b-red-secondary c-red caption">Web developer</div>
				<div class="contact-links m-top-20">
					<i class="fab fa-facebook-f c-primary"></i>
					<i class="fab fa-twitter c-primary m-left-15 m-right-15"></i>
					<i class="fab fa-linkedin-in c-primary"></i>
				</div>
			</div>
		</div>

		<!-- Project Box -->
		<div class="box b-white project-box">
			<div class="p-all-30">
				<div class="category b-green-secondary c-green caption">Web design</div>
				<h3 class="project-title c-title m-top-20 d-block">Luxx project management</h3>
				<div class="project-tasks">
					<ul class="project-task-list">
						<li class="text c-text">Design the landing page</li>
						<li class="text c-text">Module widgets functionality</li>
						<li class="text c-text">Fix the login/signup bug</li>
					</ul>
				</div>
				<div class="project-workers m-top-20">
					<div>
						<img src="<?php echo URL; ?>includes/themes/<?php echo THEME; ?>/img/1.png">
					</div>
					<div>
						<img src="<?php echo URL; ?>includes/themes/<?php echo THEME; ?>/img/2.png">
					</div>
				</div>
			</div>
			<div class="project-info">
				<div class="caption c-gray"><i class="fe fe-calendar m-right-10"></i>Deadline: <span class="caption c-primary">11 July, 2019</span></div>
			</div>
		</div>

		<!-- Invoice Box -->
		<div class="box b-white invoice-box">
			<div class="p-all-30">
				<div class="row">
					<div class="col-lg-6 text-left">
						<div class="invoice-contact-img">
							<img src="<?php echo URL; ?>includes/themes/<?php echo THEME; ?>/img/3.png" class="v-middle">
						</div>
					</div>
					<div class="col-lg-6 text-right">
						<div class="category b-yellow-secondary c-yellow ?> caption">Past due</div>
					</div>
				</div>
				<h3 class="project-title c-title m-top-20 d-block m-bottom-5">Danny Miller</h3>
				<div class="text c-text m-bottom-0">dannymiller@email.com</div>
			</div>
			<div class="invoice-info">
				<div class="row">
					<div class="invoice-info-line col-lg-6 p-right-0 p-top-15 p-bottom-15 text-center">
						<h4 class="project-title c-title m-bottom-0">23</h4>
						<div class="text c-gray">Items</div>
					</div>
					<div class="col-lg-6 p-left-0 p-top-15 p-bottom-15 text-center">
						<h4 class="project-title c-title m-bottom-0">$158</h4>
						<div class="text c-gray">Total value</div>
					</div>
				</div>
			</div>
			<div class="project-info">
				<div class="caption c-gray"><i class="fe fe-calendar m-right-10"></i>Due date: <span class="caption c-primary">10 July, 2019</span></div>
			</div>
		</div>

		<!-- Module Box -->
		<div class="box b-white p-all-30 module-box">
			<div class="module-box-img">
				<img src="<?php echo URL; ?>includes/modules/expenses/public/img/expenses-icon.svg">
			</div>
			<h4 class="c-title m-bottom-5">Expenses</h4>
			<div class="text c-text m-bottom-30">Keep track of your everyday expenses</div>
			<button class="btn b-secondary c-primary btn-block" style="cursor: default;">View</button>
		</div>

		<!-- Project Box 2 -->
		<div class="box b-white project-box-2">
			<div class="p-all-30">
				<div class="category-dot b-purple-secondary m-right-10">
					<div class="b-purple v-middle"></div>
				</div>
				<h3 class="project-title c-title m-bottom-0">Customers e-mail list</h3>
			</div>
			<div class="project-info">
				<div class="row">
					<div class="col-lg-4 text-left p-right-0">
						<div class="caption c-gray"><i class="fe fe-list-bullet m-right-10"></i><span class="c-title">10</span> / 23</div>
					</div>
					<div class="col-lg-8 text-right">
						<div class="caption c-gray"><i class="fe fe-calendar m-right-10"></i>11 July, 2019</div>
					</div>
				</div>
			</div>
			<div class="project-progress b-secondary">
				<div class="b-primary" style="width: 50%;"></div>
			</div>
		</div>

		<!-- Contact Box 2 -->
		<div class="box p-all-30 b-white contact-box-2">
			<div class="contact-image">
				<img src="<?php echo URL; ?>includes/themes/<?php echo THEME; ?>/img/2.png" class="v-middle">
			</div>
			<div class="contact-details m-left-10">
				<h4 class="contact-name c-title">Ashley Julia</h4>
				<div class="category m-top-5 b-blue-secondary c-blue caption">Graphic Designer</div>
			</div>
		</div>

		<!-- Stats Box -->
		<div class="box p-all-30 b-white stats-box">
			<div class="stats-icon b-primary text-center">
				<i class="fe fe-list-bullet c-white v-middle"></i>
			</div>
			<div class="stats-info m-left-10">
				<h2 class="stats-title c-title">374<i class="fe fe-arrow-up c-success m-left-10"></i></h2>
				<div class="stats-text text c-gray m-top-5">Project tasks</div>
			</div>
			<div class="stats-change text c-success">+5.90</div>
		</div>

		<!-- Stats Box 2 -->
		<div class="box p-all-20 b-white stats-box-2">
			<div class="projects-stats-box m-left-5 m-right-5">
				<div class="projects-stats-box-bar m-bottom-10">
					<div class="projects-stats-box-bar-height b-gray-secondary no-hover-gray" style="cursor: default; height: 30%;">
					</div>
				</div>
				<div class="projects-stats-box-bar-day text c-gray text-center">14</div>
			</div>
			<div class="projects-stats-box m-left-5 m-right-5">
				<div class="projects-stats-box-bar m-bottom-10">
					<div class="projects-stats-box-bar-height b-blue no-hover-primary" style="cursor: default; height: 100%;">
					</div>
				</div>
				<div class="projects-stats-box-bar-day text c-gray text-center">15</div>
			</div>
			<div class="projects-stats-box m-left-5 m-right-5">
				<div class="projects-stats-box-bar m-bottom-10">
					<div class="projects-stats-box-bar-height b-blue-secondary no-hover-secondary" style="cursor: default; height: 60%;">
					</div>
				</div>
				<div class="projects-stats-box-bar-day text c-gray text-center">16</div>
			</div>
		</div>

	</div>
</div>

<!-- Partners -->
<div class="container-fluid partners" id="partners">
	<div class="row">
		<div class="col-lg-2">
			<div class="partners-img">
				<img src="<?php echo URL; ?>includes/themes/<?php echo THEME; ?>/img/themeforest.svg">
			</div>
		</div>
		<div class="col-lg-2">
			<div class="partners-img">
				<img src="<?php echo URL; ?>includes/themes/<?php echo THEME; ?>/img/codecanyon.svg">
			</div>
		</div>
		<div class="col-lg-2">
			<div class="partners-img">
				<img src="<?php echo URL; ?>includes/themes/<?php echo THEME; ?>/img/graphicriver.svg">
			</div>
		</div>
		<div class="col-lg-2">
			<div class="partners-img">
				<img src="<?php echo URL; ?>includes/themes/<?php echo THEME; ?>/img/audiojungle.svg">
			</div>
		</div>
		<div class="col-lg-2">
			<div class="partners-img">
				<img src="<?php echo URL; ?>includes/themes/<?php echo THEME; ?>/img/videohive.svg">
			</div>
		</div>
		<div class="col-lg-2">
			<div class="partners-img">
				<img src="<?php echo URL; ?>includes/themes/<?php echo THEME; ?>/img/photodune.svg">
			</div>
		</div>
	</div>
</div>

<!-- Product -->
<div class="container-fluid product" id="product">
	<div class="row">
		<div class="col-lg-7">
			<div class="v-middle">
				<div class="product-img">
					<img src="<?php echo URL; ?>includes/themes/<?php echo THEME; ?>/img/product-graphic.svg">
				</div>
			</div>
		</div>
		<div class="col-lg-5">
			<div class="v-middle">
				<h1 class="c-title product-title">Discover the new way to manage your business</h1>
				<div class="text c-text m-top-20">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua enim ad minim veniam.</div>
				<div class="product-button m-top-30">
					<a href="<?php echo URL; ?>signup">
						<button class="btn b-secondary c-primary">Create Account</button>
					</a>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Modules -->
<div class="container-fluid modules text-center" id="modules">
	<h1 class="c-title">Expand your experience with the modules</h1>
	<div class="text c-text m-top-20 m-bottom-30 modules-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua enim ad minim veniam.</div>
	<button class="btn b-yellow c-white">See All</button>
	<div class="row m-top-50">
		<div class="col-lg-4">
			<div class="box b-white modules-module big" style="left: 160px; top: 50px;">
				<img src="<?php echo URL; ?>includes/themes/<?php echo THEME; ?>/img/modules/manager-icon.svg" class="v-middle">
			</div>
			<div class="box b-white modules-module medium" style="left: 0px; top: 70px;">
				<img src="<?php echo URL; ?>includes/themes/<?php echo THEME; ?>/img/modules/chat-icon.svg" class="v-middle">
			</div>
		</div>
		<div class="col-lg-4">
			<div class="box b-white modules-module small" style="left: 170px; top: 50px;">
				<img src="<?php echo URL; ?>includes/themes/<?php echo THEME; ?>/img/modules/expenses-icon.svg" class="v-middle">
			</div>
			<div class="box b-white modules-module medium" style="left: 0px; top: 20px;">
				<img src="<?php echo URL; ?>includes/themes/<?php echo THEME; ?>/img/modules/calendar-icon.svg" class="v-middle">
			</div>
			<div class="box b-white modules-module small" style="left: 150px; top: 40px;">
				<img src="<?php echo URL; ?>includes/themes/<?php echo THEME; ?>/img/modules/wallet-icon.svg" class="v-middle">
			</div>
		</div>
		<div class="col-lg-4">
			<div class="box b-white modules-module big" style="left: 0px; top: 100px;">
				<img src="<?php echo URL; ?>includes/themes/<?php echo THEME; ?>/img/modules/crypto-icon.svg" class="v-middle">
			</div>
			<div class="box b-white modules-module small" style="left: 200px; top: -30px;">
				<img src="<?php echo URL; ?>includes/themes/<?php echo THEME; ?>/img/modules/feedback-icon.svg" class="v-middle">
			</div>
		</div>
	</div>
</div>