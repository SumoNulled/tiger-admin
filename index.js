const superagent = require('superagent').agent();
const express = require('express');
const app = express();
var url = "https://app.shiftboard.com/servola/auth.cgi?ss=2034331&auth_user=dkclay%40memphis.edu&auth_password=3459847Cd&login=Login";

app.get('/', function(req, res) {
const ytm = async () => {
  var ss = "2034331";
  let username = req.query.username;
  let password = req.query.password;
  let dashboard = await superagent
  .post(url)
  .send({ss: ss, auth_user: username, auth_password: password, login: 'Login'})
  .set('Content-Type', 'application/x-www-form-urlencoded')
  .set('referrer', 'https://www.shiftboard.com/')
  .set('set-cookie', 'SB2Session=3d2bb113a7b2e9ea0d5a8a2e0ffeb3bb9b92b9cfeyIiOiJsbVV1TlBVVC04LThLeDNYdTFPTFZlX3MiLCIyMDM0MzMxIjoiaE1QcmFpU2xEdmdXd3Z0WDItVEw3YlhyIiwiY3VycmVudF9zaXRlIjoiMjAzNDMzMSJ9; SameSite=None; Secure');
  res.send(dashboard.text);

  let referral = await superagent.get('https://www.shiftboard.com/servola/security/security.cgi?launch=1edit=1ss=2034331');
  //res.send(referral.text);
}

ytm();
});
app.listen('8080');
console.log('API is running on http://localhost:8080');

module.exports = app;
