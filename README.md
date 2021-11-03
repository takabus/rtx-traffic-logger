## Yamaha RTX Traffic Logger

Get traffic data from Yamaha RTX Router.

https://takabus.com/tips/472/

## Instration

1.Log in to your router

2.For testing,command this:

```
lua -e 'rtn, lan1 = rt.command("show status lan1")rtn, lan2 = rt.command("show status lan2")rtn, pp1 = rt.command("show status pp 1")req_t = {    url = "http://test.lc/rtxlogger/api.php",    method = "POST",    content_type = "application/x-www-form-urlencoded;charset=sjis"}req_t.post_text =    string.format(    "lan1=%s&lan2=%s&pp1=%s",    lan1,    lan2,    pp1,)rt.httprequest(req_t)'
```

3.For scheduling:

```
schedule at [SCHEDULE ID] *:00 * lua -e 'rtn, lan1 = rt.command("show status lan1")rtn, l
an2 = rt.command("show status lan2")rtn, pp1 = rt.command("show status pp 1")re
q_t = {    url = "http://test.lc/rtxlogger/api.php",    method = "POST",    con
tent_type = "application/x-www-form-urlencoded;charset=sjis"}req_t.post_text =
   string.format(    "lan1=%s&lan2=%s&pp1=%s",    lan1,    lan2,    pp1,)rt.htt
prequest(req_t)'
```

The script is executed at intervals of an hour.

## Requirements

Router:YAMAHA RTX Series (Lua script)

Server side:PHP

