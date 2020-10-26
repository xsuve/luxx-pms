<!-- Calendar Widget -->
<div class="section m-bottom-20">
  <div class="text c-gray m-bottom-10">Calendar</div>
  <div class="box b-white p-all-30">
    <div id="calendarBox"></div>
  </div>
  <script type="text/javascript">
    var events = [
      <?php $i = 0; ?>
      <?php foreach($events as $event): ?>
        {
          id: '<?php echo $event->id; ?>',
          title: '<?php echo $event->title; ?>',
          start: '<?php echo date_format(date_create($event->start_date), "Y-m-d H:i:s"); ?>',
          end: '<?php echo date_format(date_create($event->end_date), "Y-m-d H:i:s"); ?>',
          allDay: <?php echo $event->all_day; ?>,
          className: 'calendar-event b-<?php echo ($event->color != '' ? $event->color : 'blue'); ?>'
        }<?php echo ($i == count($events) - 1 ? '' : ','); ?>
        <?php $i++; ?>
      <?php endforeach; ?>
    ];
  </script>
</div>