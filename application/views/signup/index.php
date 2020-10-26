<div class="container-fluid form">
  <div class="box p-all-50 b-white v-middle">
    <h1 class="c-title text-center m-bottom-50">
      <div class="form-box-logo m-right-10">
        <img src="<?php echo URL; ?>public/img/luxx-logo.svg">
      </div>
      Sign up for an account
    </h1>
    <form action="<?php echo URL; ?>signup/signupaccount" method="post">
      <?php if(isset($plan_title) && $plan_title != null): ?>
        <input type="hidden" name="plan_title" value="<?php echo $plan_title; ?>">
      <?php endif; ?>
      <div class="form-input-box">
        <div class="caption c-text m-bottom-5">Full name</div>
        <input type="text" name="name" placeholder="Enter your full name" class="text c-text">
      </div>
      <div class="form-input-box">
        <div class="caption c-text m-bottom-5">E-mail</div>
        <input type="email" name="email" placeholder="Enter the e-mail" class="text c-text">
      </div>
      <div class="form-input-box">
        <div class="caption c-text m-bottom-5">Phone number</div>
        <input type="text" name="phone_number" placeholder="Enter your phone number" class="text c-text">
      </div>
      <div class="form-input-box">
        <div class="caption c-text m-bottom-5">Password</div>
        <input type="password" name="password" placeholder="Enter the password" class="text c-text">
      </div>
      <div class="form-button m-bottom-20">
        <button type="submit" name="sign_up_account" class="btn b-primary c-white btn-block">Sign up</button>
      </div>
    </form>
    <div class="text c-text text-center">Already have an account? <a href="<?php echo URL; ?>login" class="c-primary">Log in</a></div>
  </div>
</div>