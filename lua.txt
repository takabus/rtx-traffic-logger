-- YAMAHAルーターで実行するスクリプト

-- execute router command

rtn, env = rt.command("show environment")
rtn, lan1 = rt.command("show status lan1")
rtn, lan2 = rt.command("show status lan2")
rtn, pp1 = rt.command("show status pp 1")
rtn, ppanonymous = rt.command("show status pp anonymous")
rtn, t2 = rt.command("show status tunnel 2")
rtn, t3 = rt.command("show status tunnel 3")
rtn, t5 = rt.command("show status tunnel 5")

-- post to api.php

req_t = {
  url = "http://sv02.thsv.lc/~t.h/rtxlogger/api.php",
  method = "POST",
  content_type = "application/x-www-form-urlencoded;charset=sjis"
}
req_t.post_text =
  string.format(
  "env=%s&lan1=%s&lan2=%s&pp1=%s&ppanonymous=%s&tunnel2=%s&tunnel3=%s&tunnel5=%s",
  env,
  lan1,
  lan2,
  pp1,
  ppanonymous,
  t2,
  t3,
  t5
)
rt.httprequest(req_t)
