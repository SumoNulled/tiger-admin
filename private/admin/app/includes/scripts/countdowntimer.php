<script>
(function countdown(remaining) {
if(remaining === 0)
{
  window.location.assign(document.URL);
}

const countDownID = document.getElementById('countdown');

if (countDownID !== null)
{
  document.getElementById('countdown').innerHTML = remaining;
  setTimeout(function(){ countdown(remaining - 1); }, 1000);
}
})(3);
</script>
