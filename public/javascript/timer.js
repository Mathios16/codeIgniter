function start_timer(end_time){

  $('button[type="submit"]').prop('disabled', true)
  
  var html_error = $('.error-password').html()
  $('.error-password').html(html_error + '<span class="tempo"></span>')

  end  = parseInt(end_time) * 1000

  timer_interval = setInterval(function() {

      var now                   = new Date().getTime()
      var distance              = Math.abs(now-end)
      var minutes               = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60))
      var seconds               = Math.floor((distance % (1000 * 60)) / 1000)
      
      console.log(distance)

      $('.tempo').html(minutes + ":" + seconds)
      update_timer = null
      time_update  = 0

      if(seconds == 0 && minutes == 0)
      {
          clearInterval(timer_interval)
          $('.error-password').html('')
          $('button[type="submit"]').prop('disabled', false)
          return
      }
  
  }, 1000);
}