<!-- Chat -->
<div class="container-fluid content">

  <!-- Chat -->
  <div class="box b-white">
    <div class="row">
      <div class="col-lg-3 p-right-0 chat-min-height">
        <div class="chat-header p-all-20">
          <h3 class="project-title c-title m-bottom-0">Discussions</h3>
        </div>
        <div class="chat-discussions">
          <?php if(count($account_chats) > 0): ?>
            <?php $i = 0; ?>
            <?php foreach($account_chats as $account_chat): ?>
              <?php
                $account_data = $module_model->getChatAccountData($account_chat->account_one_id);
              ?>
              <a href="#">
                <div class="discussion-box b-white p-all-20">
                  <div class="discussion-box-time caption c-gray">10m</div>
                  <div class="row">
                    <div class="col-lg-4 p-right-0">
                      <div class="discussion-box-account-image">
                        <?php if(file_exists('public/application/accounts/' . $account_data->id . '.png')): ?>
                          <img src="<?php echo URL; ?>public/application/accounts/<?php echo $account_data->id; ?>.png">
                        <?php else: ?>
                          <img src="<?php echo URL; ?>public/img/account.png">
                        <?php endif; ?>
                      </div>
                    </div>
                    <div class="col-lg-8 p-left-0">
                      <div class="discussion-box-details">
                        <h4 class="discussion-box-account-name c-title m-bottom-10"><?php echo $account_data->name; ?></h4>
                        <div class="discussion-box-text caption c-gray"><?php echo (strlen($account_chat->chat_text) > 40 ? substr($account_chat->chat_text, 0, 40) : $account_chat->chat_text); ?></div>
                      </div>
                    </div>
                  </div>
                </div>
              </a>
              <?php $i++; ?>
            <?php endforeach; ?>
          <?php else: ?>
            No chats.
          <?php endif; ?>
        </div>
      </div>
      <div class="col-lg-6 chat-discussions-texts chat-min-height">
        <div class="chat-discussions-texts-height p-top-20 p-bottom-20">
          <?php if(count($chats) > 0): ?>
            <?php $i = 0; ?>
            <?php foreach($chats as $chat): ?>
              <?php
                $account_data = $module_model->getChatAccountData($chat->account_two_id);
              ?>
              <div class="chat-box <?php echo ($i == count($chats) - 1 ? '' : 'm-bottom-15'); ?>">
                <div class="row">
                  <?php if($chat->account_one_id != $account->id): ?>
                    <div class="col-lg-1 p-right-0">
                      <div class="chat-box-account-image <?php echo ($chat->account_one_id == $account->id ? 'account-one b-primary' : 'account-two'); ?>">
                        <?php if(file_exists('public/application/accounts/' . $chat->account_one_id . '.png')): ?>
                          <img src="<?php echo URL; ?>public/application/accounts/<?php echo $chat->account_one_id; ?>.png">
                        <?php else: ?>
                          <img src="<?php echo URL; ?>public/img/account.png">
                        <?php endif; ?>
                      </div>
                    </div>
                  <?php endif; ?>
                  <div class="col-lg-11 <?php echo ($chat->account_one_id == $account->id ? 'text-right' : 'text-left'); ?>">
                    <div class="chat-box-text text-left p-top-10 p-bottom-10 p-right-15 p-left-15 text <?php echo ($chat->account_one_id == $account->id ? 'c-white account-one b-primary' : 'c-text account-two'); ?>"><?php echo $chat->chat_text; ?></div>
                    <div class="chat-box-date caption c-gray m-top-10 <?php echo ($chat->account_one_id == $account->id ? 'text-right' : 'text-left'); ?>"><?php echo date_format(date_create($chat->chat_date), 'H:i'); ?></div>
                  </div>
                  <?php if($chat->account_one_id == $account->id): ?>
                    <div class="col-lg-1 p-right-0">
                      <div class="chat-box-account-image <?php echo ($chat->account_one_id == $account->id ? 'account-one b-primary' : 'account-two'); ?>">
                        <?php if(file_exists('public/application/accounts/' . $account->id . '.png')): ?>
                          <img src="<?php echo URL; ?>public/application/accounts/<?php echo $account->id; ?>.png">
                        <?php else: ?>
                          <img src="<?php echo URL; ?>public/img/account.png">
                        <?php endif; ?>
                      </div>
                    </div>
                  <?php endif; ?>
                </div>
              </div>
              <?php $i++; ?>
            <?php endforeach; ?>
          <?php else: ?>
            No chats.
          <?php endif; ?>
        </div>
        <div class="row chat-send-message-box">
          <input type="text" name="message" class="caption c-gray p-right-15 p-left-15" placeholder="Your message">
          <div class="chat-send-message-box-btn icon-circle small b-primary c-white text-center v-middle m-right-15 m-left-15">
            <i class="fe fe-paper-plane v-middle"></i>
          </div>
        </div>
      </div>
      <div class="col-lg-3 chat-account-profile chat-min-height"></div>
    </div>
  </div>

</div>