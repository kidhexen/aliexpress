! function() {
    function t(t) {
        var e = {
            host: TTBND[2],
            l: {},
            cGA: [],
            vSa: [],
            Pxj: [],
            fiF: [],
            YAZ: 0,
            ol: 0,
            all: 0,
            tr: 0,
            IXl: 0,
            topBarElement: !1,
            reparseTimer: 0,
            reparseBody: "",
            text: {
                isNodeUpdated: function(t) {
                    function n(t) {
                        function i(t, n) {
                            var i = e.tc.t5V(n);
                            i[1] && -1 == e.indexOf(e.fiF, n) && o++
                        }
                        if (!e.hasClass(t, "notranslate") && !e.hasClass(t, "socketio")) switch (t.nodeType) {
                            case 1:
                                if ("SCRIPT" == t.tagName || "STYLE" == t.tagName || "OBJECT" == t.tagName || !t.innerHTML) return;
                                for (var r = t.childNodes, a = 0; a < r.length; a++) n(r[a]);
                                break;
                            case 3:
                                var s = t.nodeValue,
                                    c = s.length;
                                if (-1 != s.indexOf("<") && -1 != s.indexOf(">")) return;
                                i(t, s, c, 0)
                        }
                    }
                    var o = 0;
                    return n(t), o
                }
            },
            tc: {
                kGJ: "",
                P9p: {
                    b: "tt",
                    u: !0,
                    h: !1
                },
                data: {
                    ohT: [],
                    uBP: [],
                    s4W: [],
                    toh: []
                },
                f8y: {
                    oA0: -1,
                    akR: 0,
                    D6i: 0,
                    d49: 0,
                    faq: !1,
                    aAE: !1
                },
                KD1: {
                    jlk: 0,
                    tJj: []
                },
                obj: {},
                VEq: 0,
                OrW: 0,
                YGM: [],
                xlN: [9e3, 9030],
                port: !1,
                Bkt: "85.17.190.170",
                fZC: "",
                currentLang: "",
                w7j: function(t) {
                    if ("start" == t) e.tc.KD1.jlk = (new Date).getTime();
                    else {
                        if ("get" == t) {
                            e.tc.w7j("completed");
                            var n = e.tc.KD1.tJj;
                            return e.tc.KD1.jlk = 0, e.tc.KD1.tJj = [], n
                        }
                        var o = ((new Date).getTime() - e.tc.KD1.jlk).toString();
                        e.tc.KD1.tJj.push([o, t])
                    }
                },
                rk: function(t) {
                    for (var e = ["a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9"], n = e.length, o = "", i = 0; t > i; i++) o += e[Math.floor(Math.random() * n)];
                    return o
                },
                NyB: function(t, e) {
                    var n, o = {},
                        i = {},
                        r = {},
                        a = {},
                        s = {},
                        c = {};
                    if (r[0] = "HTML_SPECIALCHARS", r[1] = "HTML_ENTITIES", a[0] = "ENT_NOQUOTES", a[2] = "ENT_COMPAT", a[3] = "ENT_QUOTES", s = isNaN(t) ? t ? t.toUpperCase() : "HTML_SPECIALCHARS" : r[t], c = isNaN(e) ? e ? e.toUpperCase() : "ENT_COMPAT" : a[e], "HTML_SPECIALCHARS" !== s && "HTML_ENTITIES" !== s) throw new Error("Table: " + s + " not supported");
                    o[38] = "&", "HTML_ENTITIES" === s && (o[160] = "&nbsp;", o[161] = "&iexcl;", o[162] = "&cent;", o[163] = "&pound;", o[164] = "&curren;", o[165] = "&yen;", o[166] = "&brvbar;", o[167] = "&sect;", o[168] = "&uml;", o[169] = "&copy;", o[170] = "&ordf;", o[171] = "&laquo;", o[172] = "&not;", o[173] = "&shy;", o[174] = "&reg;", o[175] = "&macr;", o[176] = "&deg;", o[177] = "&plusmn;", o[178] = "&sup2;", o[179] = "&sup3;", o[180] = "&acute;", o[181] = "&micro;", o[182] = "&para;", o[183] = "&middot;", o[184] = "&cedil;", o[185] = "&sup1;", o[186] = "&ordm;", o[187] = "&raquo;", o[188] = "&frac14;", o[189] = "&frac12;", o[190] = "&frac34;", o[191] = "&iquest;", o[192] = "&Agrave;", o[193] = "&Aacute;", o[194] = "&Acirc;", o[195] = "&Atilde;", o[196] = "&Auml;", o[197] = "&Aring;", o[198] = "&AElig;", o[199] = "&Ccedil;", o[200] = "&Egrave;", o[201] = "&Eacute;", o[202] = "&Ecirc;", o[203] = "&Euml;", o[204] = "&Igrave;", o[205] = "&Iacute;", o[206] = "&Icirc;", o[207] = "&Iuml;", o[208] = "&ETH;", o[209] = "&Ntilde;", o[210] = "&Ograve;", o[211] = "&Oacute;", o[212] = "&Ocirc;", o[213] = "&Otilde;", o[214] = "&Ouml;", o[215] = "&times;", o[216] = "&Oslash;", o[217] = "&Ugrave;", o[218] = "&Uacute;", o[219] = "&Ucirc;", o[220] = "&Uuml;", o[221] = "&Yacute;", o[222] = "&THORN;", o[223] = "&szlig;", o[224] = "&agrave;", o[225] = "&aacute;", o[226] = "&acirc;", o[227] = "&atilde;", o[228] = "&auml;", o[229] = "&aring;", o[230] = "&aelig;", o[231] = "&ccedil;", o[232] = "&egrave;", o[233] = "&eacute;", o[234] = "&ecirc;", o[235] = "&euml;", o[236] = "&igrave;", o[237] = "&iacute;", o[238] = "&icirc;", o[239] = "&iuml;", o[240] = "&eth;", o[241] = "&ntilde;", o[242] = "&ograve;", o[243] = "&oacute;", o[244] = "&ocirc;", o[245] = "&otilde;", o[246] = "&ouml;", o[247] = "&divide;", o[248] = "&oslash;", o[249] = "&ugrave;", o[250] = "&uacute;", o[251] = "&ucirc;", o[252] = "&uuml;", o[253] = "&yacute;", o[254] = "&thorn;", o[255] = "&yuml;"), "ENT_NOQUOTES" !== c && (o[34] = "&quot;"), "ENT_QUOTES" === c && (o[39] = "&#39;"), o[60] = "&lt;", o[62] = "&gt;";
                    for (n in o) "function" != typeof o[n] && o.hasOwnProperty(n) && (i[String.fromCharCode(n)] = o[n]);
                    return i
                },
                YTA: function(t) {
                    var n = {},
                        o = "",
                        i = "",
                        r = "";
                    if (i = t.toString(), !1 === (n = e.tc.NyB("HTML_ENTITIES", "ENT_QUOTES"))) return !1;
                    delete n["&"], n["&"] = "&";
                    for (o in n) "function" != typeof n[o] && (r = n[o], i = i.split(r).join(o));
                    return i = i.split("&#039;").join("'")
                },
                pdj: function() {
                    "" != io && (clearInterval(e.tc.Fzcr), e.tc.Fzcr = 0, e.tc.ioLoaded())
                },
                LlZ: function(t) {
                    return !isNaN(parseFloat(t)) && isFinite(t)
                },
                t5V: function(t) {
                    if ("string" == typeof t) {
                        for (var e = -1, n = t.length; t.charCodeAt(--n) < 65;);
                        for (; t.charCodeAt(++e) < 65;);
                        var o = t.slice(0, e),
                            i = t.slice(e, n + 1),
                            r = t.slice(n + 1, t.length);
                        return [o, i, r]
                    }
                },
                pending: function(t, n) {
                    "object" == typeof e.tc.obj[e.tc.VEq] && e.tc.VEq++, e.tc.obj[e.tc.VEq] = {}, e.tc.obj[e.tc.VEq].associated = [], e.tc.obj[e.tc.VEq].translate = [];
                    for (var o in t)
                        if ("function" != typeof t[o] && "object" != typeof t[o]) {
                            var i = e.tc.t5V(t[o]);
                            e.tc.obj[e.tc.VEq].to = e.tc.fZC, e.tc.obj[e.tc.VEq].associated[o] = i, e.tc.obj[e.tc.VEq].translate[o] = i[1], e.tc.obj[e.tc.VEq].callback = n
                        }
                },
                completed: function() {
                    var t = e.tc.w7j("get"),
                        n = e.tc.YGM,
                        o = window.location.href || document.location.href || document.URL;
                    e.tc.send("complete", {
                        b: t,
                        d: n,
                        url: o.split("://")[1],
                        unique: e.tc.f8y.aAE
                    }), e.tc.obj = {}, e.tc.VEq = 0, e.tc.f8y.oA0 = -1, e.tc.f8y.aAE = !1, e.tc.currentLang = e.tc.fZC
                },
                wQJ: function() {
                    if (1 == e.tc.f8y.oA0) {
                        e.tc.f8y.oA0 = 2;
                        for (var t = 0, n = 0; !n; t++) {
                            var o = "";
                            for (var i in e.tc.obj)
                                if ("function" != typeof e.tc.obj[i])
                                    for (var r in e.tc.obj[i].translate)
                                        if ("string" == typeof e.tc.obj[i].translate[r]) {
                                            var a = e.tc.t5V(e.tc.obj[i].translate[r]),
                                                s = a[1].split(" ").length;
                                            (1 == t || s > 3) && (o += a[1], o += s > 3 ? ". " : " ")
                                        }(o.length > 500 || 1 == t) && (n = 1)
                        }
                        o = o.substr(0, e.o.maxLength);
                        var c = window.location.href || document.location.href || document.URL;
                        return c.match("/^((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2}).){3}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})$/") ? void alert("Using the button on IP addresses is currently not supported.") : "/" == c.split("://")[1].substr(0, 1) ? void alert("The TranslateThis Button currently only supports live websites.") : "localhost" == c.split("://")[1].split(":")[0] || -1 == c.indexOf(".") ? void alert("The TranslateThis Button currently only supports live websites.") : void e.tc.send("unique", {
                            url: c.split("://")[1],
                            to: e.tc.fZC,
                            data: o,
                            id: e.o.id
                        })
                    }
                },
                ioLoaded: function() {
                    var t = "http://";
                    "https:" == document.location.protocol && (t = "https://", e.tc.Bkt = "coboltcloud.com", e.tc.port = 9050), e.tc.kGJ = io.connect(t + e.tc.Bkt + ":" + e.tc.port), e.tc.send = function(t, n) {
                        e.tc.kGJ.emit(t, n)
                    }, e.tc.kGJ.on("connect", function() {
                        e.tc.w7j("socket connected to http://" + e.tc.Bkt + ":" + e.tc.port), e.tc.wQJ()
                    }), e.tc.kGJ.on("cancel", function() {
                        e.removeTopBar(), e.trans(0)
                    }), e.tc.kGJ.on("gs", function() {
                        e.setCookie("", -1);
                        var t = window.location.href || document.location.href || document.URL;
                        window.location.href = "http://translate.google.com/translate?sl=auto&tl=" + e.tc.fZC + "&u=" + t
                    }), e.tc.kGJ.on("unique", function(t) {
                        e.tc.w7j("received unique"), e.tc.f8y.aAE = t.data;
                        var n = 0,
                            o = window.location.href || document.location.href || document.URL;
                        for (var i in e.tc.obj) "function" != typeof e.tc.obj[i] && (e.tc.send("translate", {
                            unique: t.data,
                            id: n,
                            data: e.tc.obj[i].translate,
                            to: e.tc.obj[i].to,
                            url: o.split("://")[1]
                        }), n++)
                    }), e.tc.kGJ.on("translated", function(t) {
                        "string" == typeof t.data && (t.data = JSON.parse(t.data)), e.tc.w7j("received translation");
                        for (var n = [], o = 0; o < e.tc.obj[t.id].associated.length; o++) "function" != typeof e.tc.obj[t.id].associated[o] && -1 == t.data[o].indexOf("text-align:right;direction:rtl") && n.push(e.tc.obj[t.id].associated[o][0] != e.tc.obj[t.id].associated[o][2] || e.tc.YTA(t.data[o]) ? e.tc.obj[t.id].associated[o][0] + e.tc.YTA(t.data[o]) + e.tc.obj[t.id].associated[o][2] : e.tc.obj[t.id].associated[o][0]);
                        var i = {
                            Aec: n
                        };
                        e.tc.obj[t.id].callback(i)
                    })
                },
                i: function() {
                    "object" == typeof e.tc.kGJ ? e.tc.wQJ() : 0 == e.tc.f8y.d49 && (e.tc.f8y.d49 = 1, e.tc.port || (e.tc.port = Math.floor(Math.random() * (e.tc.xlN[1] - e.tc.xlN[0] + 1) + e.tc.xlN[0])), e.tc.Fzcr = setInterval(function() {
                        e.tc.pdj()
                    }, 25))
                }
            },
            Gn1: function(t, e, n) {
                t.attachEvent ? (t["e" + e + n] = n, t[e + n] = function() {
                    t["e" + e + n](window.event)
                }, t.attachEvent("on" + e, t[e + n])) : t.addEventListener(e, n, !1)
            },
            tvU: function(t) {
                t && t.tvUentDefault ? t.tvUentDefault() : window.event && window.event.returnValue && (window.event.returnValue = !1)
            },
            trans: function(t, n) {
                function o(t) {
                    function n(t, n, o, r) {
                        var a = e.tc.t5V(n);
                        a[1] && -1 == e.indexOf(e.fiF, a[1]) && (d += o, (d >= h || u.length > 128) && (i(), c(o)), p.push(t), l.push(r), u.push(n))
                    }
                    if (!e.hasClass(t, "notranslate") && !e.hasClass(t, "socketio")) switch (t.nodeType) {
                        case 1:
                            switch (t.tagName) {
                                case "SCRIPT":
                                case "STYLE":
                                case "OBJECT":
                                    return
                            }
                            if (!t.innerHTML) return;
                            for (var r = t.childNodes, a = 0, s = r.length; s > a; a++) o(r[a]);
                            break;
                        case 3:
                            var f = t.nodeValue,
                                m = f.length;
                            if (-1 != f.indexOf("<") && -1 != f.indexOf(">")) return;
                            if (h > m) n(t, f, m, 0);
                            else
                                for (var g = 0; f.length; g++) n(t, f.substr(0, h), f.length, g ? 1 : 0), f = f.substr(h)
                    }
                }

                function i() {
                    var t = {
                        nodes: p,
                        appends: l,
                        html: u
                    };
                    t.html.length > 0 && (e.Pxj.push(t), r(t))
                }

                function r(t) {
                    t.html.length && (e.YAZ++, e.tc.pending(t.html, function(n) {
                        e.cancel || (n.error || a(t, n.Aec), e.YAZ--, e.YAZ || s(0))
                    }))
                }

                function a(t, n) {
                    for (var o = t.nodes, i = 0, r = n.length; r > i; i++) {
                        var a = o[i],
                            s = n[i];
                        if ("undefined" == typeof a) return;
                        e.fiF.push(s), a.nodeValue = s
                    }
                }

                function s(o) {
                    e.wrap = document.getElementById(e.o.wrapper);
                    var i = e.fCTA();
                    if (e.bCTA(i), !o && (e.o.autoReparse && (e.o.autoReparse && (e.o.autoReparse = 500), e.reparseBody = document.body.innerHTML, e.reparseTimer = setInterval(function() {
                            e.reparseBody != document.body.innerHTML && (e.text.isNodeUpdated(document.body) && e.trans(e.tc.fZC, 1), e.reparseBody = document.body.innerHTML)
                        }, e.o.autoReparse)), e.o.cookie && e.setCookie(t, 30), "function" == typeof e.o.onComplete && e.o.onComplete(t), e.o.IXlTime >= 0 && 0 == n)) {
                        var r = document.createElement("a"),
                            a = e.o.doneText + " - ";
                        try {
                            r.href = "#"
                        } catch (s) {}
                        r.innerHTML = e.o.IXlText, r.onclick = function(t) {
                            e.tvU(t), e.removeTopBar(), e.trans(0)
                        }, e.topBar(a, e.o.IXlTime), e.topBarElement.appendChild(r)
                    }
                    e.tc.completed()
                }

                function c(t) {
                    p = [], l = [], u = [], d = t
                }
                var n = n || 0;
                e.reparseTimer && (clearInterval(e.reparseTimer), e.reparseTimer = 0), e.tc.fZC = t, e.dd && (e.rem(e.dd), e.dd = 0, e.cGA = []), e.all && (e.rem(e.all), e.all = 0, e.vSa = []), e.YAZ = 1, t && e.topBarElement && e.removeTopBar(), t ? (e.o.IXlTime >= 0 && 0 == n && e.topBar(), e.tc.f8y.faq = e.l[t]) : (e.tc.f8y.faq = !1, e.tc.f8y.aAE = !1);
                var p, l, u, d;
                c(0);
                var h = e.o.maxLength;
                if (t && t != e.o.fromLang) {
                    if (e.cancel = 0, e.tc.f8y.oA0 = 1, !e.Pxj.length || e.o.reparse || e.o.autoReparse && e.tc.fZC == e.tc.currentLang) o(e.o.scope ? document.getElementById(e.o.scope) : document.body), i();
                    else {
                        var f = e.Pxj;
                        for (var m in f) r(f[m])
                    }
                    e.tc.i(), e.YAZ--, e.YAZ || s(0), "function" == typeof e.o.onClick && e.o.onClick()
                } else if (!e.cancel) {
                    e.cancel = 1, e.setCookie("", -1);
                    for (var f = e.Pxj, m = 0, g = f.length; g > m; m++) a(f[m], f[m].html);
                    e.Pxj = [], e.fiF = [], e.Gbx(0), e.YAZ = 0, e.removeTopBar(), s(1)
                }
            },
            b: function() {
                function t() {
                    var t = document.createElement("style"),
                        n = "display:block;overflow:hidden;text-indent:-2000px;",
                        o = "background:#FFF;border:1px solid #BBB;font-family:Arial;color:#555;",
                        i = ".ttb-panel{display:none;position:absolute;z-index:2147483647;font-size:12px;text-align:left;" + o + "} .ttb-panel .ttb-column{width:118px;float:left;margin:0 3px 0 0;} .ttb-panel a{color:#555}";
                    e.o.noBtn || (i += " #" + e.o.wrapper + " ." + TTBND[1] + "-button{background:url('" + e.o.btnImg + "') no-repeat;visibility:visible;position:relative;width:" + e.o.btnWidth + "px;height:" + e.o.btnHeight + "px;float:left;" + n + "}"), i += " .ttb-more{float:right;padding:4px;} .ttb-close{display:block;position:absolute;top:3px;right:3px;height:16px;width:16px;}", i += " .ttb-cta{display:block;padding:4px 5px;text-decoration:none;cursor:pointer;} .ttb-cta:hover{background:#EEE;outline:1px solid #CCC;text-decoration:underline;}", i += " .translate-flag{background:url('" + e.o.bgImg + "') no-repeat;height:" + e.o.imgHeight + "px;width:" + e.o.imgWidth + "px;margin:0 6px 0 0;float:left;" + n + "}", i += " .ttb-overlay{position:absolute;top:0;left:0;z-index:2147483645;background:#222;filter:alpha(opacity=80);opacity:.8;} .ttb-translating{position:absolute;z-index:3500;height:80px;width:200px;font-size:16px;text-align:center;line-height:40px;" + o + "} .ttb-translating a{font-size:.8em;}", i += " .ttb-topbar{position:absolute;width:100%;z-index:2147483646;top:0;left:0;padding:5px 0;text-align:center;font-size:13px;font-family:Arial;color:#444;border:0;box-shadow:0px 4px 15px #222222;-moz-box-shadow:0px 4px 15px #222222;-webkit-box-shadow:0px 4px 15px #222222; background: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/Pgo8c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgdmlld0JveD0iMCAwIDEgMSIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+CiAgPGxpbmVhckdyYWRpZW50IGlkPSJncmFkLXVjZ2ctZ2VuZXJhdGVkIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgeDE9IjAlIiB5MT0iMCUiIHgyPSIwJSIgeTI9IjEwMCUiPgogICAgPHN0b3Agb2Zmc2V0PSIwJSIgc3RvcC1jb2xvcj0iI2ZmZmZmZiIgc3RvcC1vcGFjaXR5PSIwLjk2Ii8+CiAgICA8c3RvcCBvZmZzZXQ9IjEwMCUiIHN0b3AtY29sb3I9IiNlNWU1ZTUiIHN0b3Atb3BhY2l0eT0iMC45NiIvPgogIDwvbGluZWFyR3JhZGllbnQ+CiAgPHJlY3QgeD0iMCIgeT0iMCIgd2lkdGg9IjEiIGhlaWdodD0iMSIgZmlsbD0idXJsKCNncmFkLXVjZ2ctZ2VuZXJhdGVkKSIgLz4KPC9zdmc+);background: -moz-linear-gradient(top,  rgba(255,255,255,0.98) 0%, rgba(229,229,229,0.96) 100%);background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(255,255,255,0.98)), color-stop(100%,rgba(229,229,229,0.96)));background: -webkit-linear-gradient(top,  rgba(255,255,255,0.96) 0%,rgba(229,229,229,0.98) 100%);background: -o-linear-gradient(top,  rgba(255,255,255,0.96) 0%,rgba(229,229,229,0.96) 100%);background: -ms-linear-gradient(top,  rgba(255,255,255,0.98) 0%,rgba(229,229,229,0.96) 100%);background: linear-gradient(top,  rgba(255,255,255,0.96) 0%,rgba(229,229,229,0.98) 100%);filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f5ffffff', endColorstr='#f5e5e5e5',GradientType=0 ); }", i += " .ttb-paneltop {background:#EEE;border-bottom:1px solid #CCC;padding:6px 5px 3px 5px;text-align:center;}", t.type = "text/css", t.styleSheet ? t.styleSheet.cssText = i : t.appendChild(document.createTextNode(i)), document.getElementsByTagName("head")[0].appendChild(t)
                }
                if (e.parseId(), e.wrap = document.getElementById(e.o.wrapper), e.wrap) {
                    var n = e.fCTA();
                    if (n && !(e.lynx.toLowerCase() != n.href.toLowerCase().substr(0, e.lynx.length) && n.href.indexOf(e.lynx2.toLowerCase()) < 0) || !e.tc.P9p.u) {
                        e.tc.YGM = {
                            h: n.href,
                            a: n.innerHTML
                        };
                        try {
                            n.href = "#translate"
                        } catch (o) {}
                        if (e.o.cookie && !e.YAZ) {
                            var i = e.getCookie();
                            i && e.trans(i)
                        }
                        t(), e.wrap.style.height = e.o.btnHeight + "px", e.bCTA(n), e.appendClear(e.wrap, 1), "function" == typeof e.o.onLoad && e.o.onLoad()
                    }
                }
            },
            bFlag: function(t) {
                var n = document.createElement("a");
                n.className = "translate-" + t + " ttb-cta", n.title = "Translate into " + e.l[t], n.href = "#translate-" + t;
                var o = document.createElement("span");
                if (o.className = "translate-label", o.innerHTML = e.l[t], e.o.noImg) return n.appendChild(o), n;
                var i = document.createElement("span");
                return i.className = "translate-flag", i.style.backgroundPosition = "0 " + e.o.imgMap[t] * e.o.imgHeight * -1 + "px", n.appendChild(i), n.appendChild(o), n
            },
            fCTA: function() {
                for (var t = e.wrap.childNodes, n = 0; n < t.length; n++)
                    if (t[n].className == TTBND[1] + "-button") return t[n];
                return !1
            },
            bCTA: function(t) {
                function n() {
                    e.dd = e.bPanel(1), e.dd.style.width = "250px", e.dd.onmouseover = o, e.dd.onmouseout = i
                }

                function o() {
                    if (a) return void clearTimeout(a);
                    e.dd || n();
                    var o = e.gPos(t);
                    e.dd.style.top = "-1000px", e.dd.style.display = "block";
                    var i = e.dd.offsetWidth;
                    e.dd.style.left = o[0] + (document.body.offsetWidth - o[0] > i ? 0 : t.offsetWidth - i) + "px";
                    var r = e.dd.offsetHeight;
                    e.dd.style.top = o[1] + (Math.max(e.wY(), document.body.offsetHeight) - o[1] > r ? t.offsetHeight : -1 * r) + "px"
                }

                function i() {
                    a = setTimeout(r, 500)
                }

                function r() {
                    a = 0, e.dd.style && (e.dd.style.display = "none")
                }
                var a = 0;
                t.onclick = e.o.onlyDD ? e.tvU : e.showAll, t.onmouseover = o, t.onmouseout = i
            },
            bPanel: function(t) {
                function n() {
                    f.innerHTML = '<a href="//www.translatecompany.com/translate-this/" title="Get your own TranslateThis Button" target="_blank"><b>TranslateThis Button</b></a> by <a href="//www.translatecompany.com/" target="_blank"><b>Translate Company</b></a>'
                }

                function o(t) {
                    e.tvU(t);
                    var n = e.gTar(t.target || t.srcElement);
                    return e.hasClass(n, "ttb-cta") ? e.flagClick(t, n, i, r) : e.hasClass(n, "ttb-more") ? e.showAll() : e.hasClass(n, "ttb-close") && e.hideAll(), !1
                }
                if (0 == e.tc.f8y.d49 && e.tc.i(), t) var i = e.cGA,
                    r = e.o.ddLangs,
                    a = 2,
                    s = 0;
                else var i = e.vSa,
                    r = e.o.allLangs,
                    a = 4,
                    s = "5px";
                var c = document.createElement("div");
                if (c.className = "ttb-panel notranslate", e.tc.f8y.faq) var p = '<div class="ttb-paneltop" id="ttb-paneltop">' + e.tc.f8y.faq + " - </div>";
                else var p = '<div class="ttb-paneltop" id="ttb-paneltop"><b>' + e.o.panelText + "</b></div>";
                if (c.innerHTML = "<div>" + p + '</div><div style="padding:5px 0 ' + s + ' 5px;"></div><div style="background:#EEE;border-top:1px solid #CCC;font-size:10px;padding:3px 0;text-align:center;"></div>', document.body.appendChild(c), e.tc.f8y.faq) {
                    var l = document.createElement("a");
                    try {
                        l.href = "#"
                    } catch (u) {}
                    l.innerHTML = e.o.IXlText, l.onclick = function(t) {
                        e.tvU(t), e.removeTopBar(), e.trans(0)
                    }, document.getElementById("ttb-paneltop").appendChild(l)
                }
                for (var d = c.childNodes[1], h = [], f = c.childNodes[2], m = 0; a > m; m++) h[m] = document.createElement("div"), h[m].className = "ttb-column", d.appendChild(h[m]);
                for (var g = 0, m = 0; m < r.length; m++) {
                    var y = e.bFlag(r[m]);
                    m >= r.length / a * (g + 1) && g++, h[g].appendChild(y), t ? e.cGA.push(y) : e.vSa.push(y)
                }
                if (e.Gn1(d, "click", o), "none" != e.tc.P9p.b && (n("TranslateThis Button by Translate Company", "Get your own TranslateThis Button", !t), t || n("What's This?", "What is the TranslateThis Button?", 0)), !t || !e.o.onlyDD) {
                    var v = document.createElement("a");
                    v.style.cursor = "pointer", t ? (v.className = "ttb-more", v.innerHTML = e.o.moreText) : (v.className = "ttb-close", e.o.noImg ? v.innerHTML = "X" : (v.style.backgroundImage = 'url("' + e.o.bgImg + '")', v.style.backgroundPosition = "0 -696px"), v.title = "Close"), d.appendChild(v)
                }
                return e.appendClear(d, 0), c
            },
            appendClear: function(t, e) {
                var n = document.createElement("div");
                n.style.margin = "0", n.style.padding = "0", e ? (n.style.width = "100%", n.style.height = "1px") : n.style.clear = "both", t.appendChild(n)
            },
            gPos: function(t) {
                var e = curtop = 0;
                if (t.offsetParent) {
                    do e += t.offsetLeft, curtop += t.offsetTop; while (t = t.offsetParent);
                    return [e, curtop]
                }
            },
            gTar: function(t) {
                return "A" != t.tagName && (t = t.parentNode), t
            },
            flagClick: function(t, n, o, i) {
                function r(t, e) {
                    for (var n = 0; n < e.length; n++)
                        if (t == e[n]) return n
                }
                e.hideAll(t);
                var a = r(n, o);
                e.trans(i[a])
            },
            removeTopBar: function() {
                0 != e.topBarElement && (e.rem(e.topBarElement), e.topBarElement = !1, e.topBarTimer && (clearTimeout(e.topBarTimer), e.topBarTimer = !1))
            },
            topBar: function(t, n) {
                function o() {
                    e.topBarPx--, e.topBarPx > -35 ? (e.topBarElement.style.top = e.topBarPx + "px", setTimeout(o, 12)) : e.removeTopBar()
                }
                if ("hide" == t) o();
                else if (t) e.topBarElement.innerHTML = t;
                else {
                    var i = document.createElement("div"),
                        r = document.createElement("a");
                    i.className = "ttb-topbar notranslate", i.innerHTML = e.o.YAZText + " ", r.innerHTML = e.o.cancelText;
                    try {
                        r.href = "#"
                    } catch (a) {}
                    r.onclick = function(t) {
                        e.tvU(t), hideTopBar(), e.trans(0)
                    }, r.style.display = "none", i.appendChild(r), document.body.appendChild(i), e.topBarElement = i
                }
                n && (e.topBarTimer = setTimeout(function() {
                    e.topBarPx = 0, o()
                }, n))
            },
            showOL: function() {
                function t() {
                    var t = document.createElement("div");
                    return t.className = "ttb-overlay", document.body.appendChild(t), t.onclick = function(t) {
                        e.hideAll(t)
                    }, window.onresize = function() {
                        e.resize = setTimeout(n, 80)
                    }, t
                }

                function n() {
                    if (e.olShow) {
                        var t = document,
                            n = Math.max(Math.max(t.body.scrollWidth, t.documentElement.scrollWidth), Math.max(t.body.offsetWidth, t.documentElement.offsetWidth), Math.max(t.body.clientWidth, t.documentElement.clientWidth)),
                            o = Math.max(Math.max(t.body.scrollHeight, t.documentElement.scrollHeight), Math.max(t.body.offsetHeight, t.documentElement.offsetHeight), Math.max(t.body.clientHeight, t.documentElement.clientHeight));
                        e.ol.style.width = n + "px", e.ol.style.height = o + "px"
                    }
                }
                e.olShow = 1, e.ol || (e.ol = t()), n(), e.ol.style.display = "block", e.dd && (e.dd.style.display = "none")
            },
            hideOL: function() {
                e.ol.style.display = "none", e.olShow = 0
            },
            showAll: function(t) {
                function n() {
                    var t = e.bPanel(0);
                    return t.style.width = "492px", t
                }
                e.tvU(t), e.showOL(), e.all || (e.all = n()), e.centerXY(e.all, 246, 190), e.all.style.display = "block"
            },
            hideAll: function(t) {
                e.tvU(t), e.all && (e.all.style.display = "none", e.hideOL())
            },
            centerXY: function(t, n, o) {
                var i = 0,
                    r = 0;
                "number" == typeof window.pageYOffset ? (r = window.pageYOffset, i = window.pageXOffset) : document.body && (document.body.scrollLeft || document.body.scrollTop) ? (r = document.body.scrollTop, i = document.body.scrollLeft) : document.documentElement && (document.documentElement.scrollLeft || document.documentElement.scrollTop) && (r = document.documentElement.scrollTop, i = document.documentElement.scrollLeft), i += e.wX() / 2 - n, r += e.wY() / 2 - o, t.style.top = r + "px", t.style.left = i + "px"
            },
            wX: function() {
                return window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : document.body.clientWidth
            },
            wY: function() {
                return window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : document.body.clientHeight
            },
            rem: function(t) {
                t.parentNode.removeChild(t)
            },
            setCookie: function(t, n) {
                var o = new Date;
                o.setTime(o.getTime() + 864e4 * n), document.cookie = e.o.cookie + "=" + t + "; expires=" + o.toGMTString() + "; path=/"
            },
            getCookie: function() {
                for (var t = e.o.cookie + "=", n = document.cookie.split(";"), o = 0; o < n.length; o++) {
                    for (var i = n[o];
                        " " == i.charAt(0);) i = i.substring(1, i.length);
                    if (0 == i.indexOf(t)) return i.substring(t.length, i.length)
                }
                return null
            },
            Gbx: function(t) {
                e.o.GA && "init" != t && "undefined" != typeof pageTracker && pageTracker._trackPageview("TranslateThis-" + t), "https:" == document.location.protocol
            },
            indexOf: function(t, e) {
                for (var n = 0; n < t.length; n++)
                    if (t[n] == e) return n;
                return -1
            },
            hasClass: function(t, e) {
                var n = " " + e + " ";
                return (" " + t.className + " ").replace(/[\n\t]/g, " ").indexOf(n) > -1 ? !0 : !1
            },
            parseId: function() {
                if (0 != e.o.id) {
                    var t = e.o.id.split(".")[1];
                    t && (t.indexOf("b") !== !1 && (e.tc.P9p.b = "none"), t.indexOf("u") !== !1 && (e.tc.P9p.u = !1))
                }
            },
            demoteFlash: function() {
                for (var t = document.getElementsByTagName("embed"), e = 0; e < t.length; e++) t[e].setAttribute("wmode", "opaque");
                for (var n = document.getElementsByTagName("object"), o = [], e = 0; e < n.length; e++) o[e] = n[e];
                for (var e = 0; e < o.length; e++) {
                    var i = document.createElement("param");
                    i.setAttribute("name", "wmode"), i.setAttribute("value", "opaque"), o[e].appendChild(i);
                    var r = document.createElement("div");
                    if (o[e].parentNode.appendChild(r), o[e].outerHTML) {
                        var a = o[e].outerHTML;
                        o[e].parentNode.removeChild(o[e]), r.innerHTML = a
                    } else o[e].parentNode.removeChild(o[e]), r.appendChild(o[e])
                }
            }
        };
        e.lynx = "http://translateTH.IS/", e.lynx2 = ".translatecompany.";
        var t = t || [];
        if (t.wrapper = t.wrapper || TTBND[1], t.scope = t.scope || !1, t.bgImg = t.bgImg || "http://" + e.host + "/tt-sprite3.png", t.fromLang = t.fromLang || "", t.flags = t.flags || [], "" == t.fromLang || "en" == t.fromLang) var n = ["fr", "es", "ar", "zh-CN", "ko", "it", "cs", "iw", "de", "pt-PT", "ru", "ja", "vi", "el", "hi", "tr"];
        else var n = ["en", "fr", "es", "ar", "zh-CN", "ko", "it", "iw", "de", "pt-PT", "ru", "ja", "vi", "el", "hi", "tr"];
        t.ddLangs = t.ddLangs || n, t.imgMap = t.imgMap || {
            af: 10,
            sq: 11,
            ar: 6,
            be: 12,
            bg: 13,
            ca: 50,
            "zh-CN": 7,
            "zh-TW": 14,
            hr: 15,
            cs: 16,
            da: 17,
            nl: 18,
            en: 19,
            et: 21,
            fi: 22,
            fr: 0,
            gl: 51,
            de: 1,
            el: 23,
            iw: 24,
            hi: 25,
            hu: 26,
            is: 27,
            id: 28,
            ga: 29,
            it: 4,
            ja: 8,
            ko: 9,
            lv: 30,
            lt: 31,
            mk: 32,
            ms: 33,
            mt: 34,
            no: 35,
            fa: 36,
            pl: 37,
            "pt-PT": 3,
            ro: 38,
            ru: 5,
            sr: 39,
            sk: 40,
            sl: 41,
            es: 2,
            sw: 42,
            sv: 43,
            tl: 44,
            th: 45,
            tr: 46,
            uk: 47,
            vi: 48,
            cy: 49,
            yi: 24
        }, void 0 === t.allLangs && (t.allLangs = ["af", "sq", "ar", "be", "bg", "ca", "zh-CN", "zh-TW", "hr", "cs", "da", "nl", "en", "et", "fi", "fr", "gl", "de", "el", "iw", "hi", "hu", "is", "id", "ga", "it", "ja", "ko", "lv", "lt", "mk", "ms", "mt", "no", "fa", "pl", "pt-PT", "ro", "ru", "sr", "sk", "sl", "es", "sw", "sv", "tl", "th", "tr", "uk", "vi", "cy", "yi"]), t.noBtn = t.noBtn || !1, t.btnWidth = t.btnWidth || 180, t.btnHeight = t.btnHeight || 18, t.noImg = t.noImg || !1, t.imgHeight = t.imgHeight || 12, t.imgWidth = t.imgWidth || 18, t.maxLength = 4500, t.onlyDD = t.onlyDD || !1, void 0 === t.IXlTime && (t.IXlTime = -1), t.onLoad = t.onLoad || null, t.onClick = t.onClick || null, t.onComplete = t.onComplete || null, t.GA = t.GA || !1, t.cookie = void 0 !== t.cookie ? t.cookie : "tt-lang", t.IXlText = t.IXlText || "Undo &raquo;", t.panelText = t.panelText || "Translate Into", t.moreText = t.moreText || t.allLangs.length - t.ddLangs.length + " More Languages &raquo;", t.YAZText = t.YAZText || "Translating Page...", t.cancelText = t.cancelText || "cancel", t.doneText = t.doneText || "Translation Complete", t.msie = /(msie) ([\w.]+)/.exec(navigator.userAgent.toLowerCase()) || !1, t.btnImg = t.btnImg || "http://" + e.host + "/tt-btn1.png", t.id = t.id || !1, t.autoReparse = t.autoReparse || !1, e.o = t;
        var o = {
            AFRIKAANS: "af",
            ALBANIAN: "sq",
            AMHARIC: "am",
            ARABIC: "ar",
            ARMENIAN: "hy",
            AZERBAIJANI: "az",
            BASQUE: "eu",
            BELARUSIAN: "be",
            BENGALI: "bn",
            BIHARI: "bh",
            BULGARIAN: "bg",
            BURMESE: "my",
            BRETON: "br",
            CATALAN: "ca",
            CHEROKEE: "chr",
            CHINESE: "zh",
            CHINESE_SIMPLIFIED: "zh-CN",
            CHINESE_TRADITIONAL: "zh-TW",
            CORSICAN: "co",
            CROATIAN: "hr",
            CZECH: "cs",
            DANISH: "da",
            DHIVEHI: "dv",
            DUTCH: "nl",
            ENGLISH: "en",
            ESPERANTO: "eo",
            ESTONIAN: "et",
            FAROESE: "fo",
            FILIPINO: "tl",
            FINNISH: "fi",
            FRENCH: "fr",
            FRISIAN: "fy",
            GALICIAN: "gl",
            GEORGIAN: "ka",
            GERMAN: "de",
            GREEK: "el",
            GUJARATI: "gu",
            HAITIAN_CREOLE: "ht",
            HEBREW: "iw",
            HINDI: "hi",
            HUNGARIAN: "hu",
            ICELANDIC: "is",
            INDONESIAN: "id",
            INUKTITUT: "iu",
            IRISH: "ga",
            ITALIAN: "it",
            JAPANESE: "ja",
            JAVANESE: "jw",
            KANNADA: "kn",
            KAZAKH: "kk",
            KHMER: "km",
            KOREAN: "ko",
            KURDISH: "ku",
            KYRGYZ: "ky",
            LAO: "lo",
            LAOTHIAN: "lo",
            LATIN: "la",
            LATVIAN: "lv",
            LITHUANIAN: "lt",
            LUXEMBOURGISH: "lb",
            MACEDONIAN: "mk",
            MALAY: "ms",
            MALAYALAM: "ml",
            MALTESE: "mt",
            MAORI: "mi",
            MARATHI: "mr",
            MONGOLIAN: "mn",
            NEPALI: "ne",
            NORWEGIAN: "no",
            OCCITAN: "oc",
            ORIYA: "or",
            PASHTO: "ps",
            PERSIAN: "fa",
            POLISH: "pl",
            PORTUGUESE: "pt",
            PORTUGUESE_PORTUGAL: "pt-PT",
            PUNJABI: "pa",
            QUECHUA: "qu",
            ROMANIAN: "ro",
            RUSSIAN: "ru",
            SANSKRIT: "sa",
            SCOTS_GAELIC: "gd",
            SERBIAN: "sr",
            SINDHI: "sd",
            SINHALESE: "si",
            SLOVAK: "sk",
            SLOVENIAN: "sl",
            SPANISH: "es",
            SUNDANESE: "su",
            SWAHILI: "sw",
            SWEDISH: "sv",
            SYRIAC: "syr",
            TAJIK: "tg",
            TAMIL: "ta",
            TAGALOG: "tl",
            TATAR: "tt",
            TELUGU: "te",
            THAI: "th",
            TIBETAN: "bo",
            TONGA: "to",
            TURKISH: "tr",
            UKRAINIAN: "uk",
            URDU: "ur",
            UZBEK: "uz",
            UIGHUR: "ug",
            VIETNAMESE: "vi",
            WELSH: "cy",
            YIDDISH: "yi",
            YORUBA: "yo",
            UNKNOWN: ""
        };
        for (l in o) {
            var i = o[l],
                r = l.replace("_", " ").toLowerCase();
            r = r.charAt(0).toUpperCase() + r.substr(1, r.length), e.l[i] = r
        }
        e.l["zh-CN"] = "Chinese", e.l["zh-TW"] = "Chinese (trad.)", e.l["pt-PT"] = "Portuguese";
        var a = window.onload ? window.onload : function() {};
        window.onload = function() {
            a(), new e.b
        }
    }
    window.TTBND = ["TranslateThis", "translate-this", "x.translateth.is"], window[TTBND[0]] = t
}();
var io = "undefined" == typeof module ? {} : module.exports;
! function() {
    ! function(t, e) {
        var n = t;
        n.version = "0.9.16", n.protocol = 1, n.transports = [], n.j = [], n.sockets = {}, n.connect = function(t, o) {
            var i, r, a = n.util.parseUri(t);
            e && e.location && (a.protocol = a.protocol || e.location.protocol.slice(0, -1), a.host = a.host || (e.document ? e.document.domain : e.location.hostname), a.port = a.port || e.location.port), i = n.util.uniqueUri(a);
            var s = {
                host: a.host,
                secure: "https" == a.protocol,
                port: a.port || ("https" == a.protocol ? 443 : 80),
                query: a.query || ""
            };
            return n.util.merge(s, o), (s["force new connection"] || !n.sockets[i]) && (r = new n.Socket(s)), !s["force new connection"] && r && (n.sockets[i] = r), r = r || n.sockets[i], r.of(a.path.length > 1 ? a.path : "")
        }
    }("object" == typeof module ? module.exports : this.io = {}, this),
    function(t, e) {
        var n = t.util = {},
            o = /^(?:(?![^:@]+:[^:@\/]*@)([^:\/?#.]+):)?(?:\/\/)?((?:(([^:@]*)(?::([^:@]*))?)?@)?([^:\/?#]*)(?::(\d*))?)(((\/(?:[^?#](?![^?#\/]*\.[^?#\/.]+(?:[?#]|$)))*\/?)?([^?#\/]*))(?:\?([^#]*))?(?:#(.*))?)/,
            i = ["source", "protocol", "authority", "userInfo", "user", "password", "host", "port", "relative", "path", "directory", "file", "query", "anchor"];
        n.parseUri = function(t) {
            for (var e = o.exec(t || ""), n = {}, r = 14; r--;) n[i[r]] = e[r] || "";
            return n
        }, n.uniqueUri = function(t) {
            var n = t.protocol,
                o = t.host,
                i = t.port;
            return "document" in e ? (o = o || document.domain, i = i || ("https" == n && "https:" !== document.location.protocol ? 443 : document.location.port)) : (o = o || "localhost", i || "https" != n || (i = 443)), (n || "http") + "://" + o + ":" + (i || 80)
        }, n.query = function(t, e) {
            var o = n.chunkQuery(t || ""),
                i = [];
            n.merge(o, n.chunkQuery(e || ""));
            for (var r in o) o.hasOwnProperty(r) && i.push(r + "=" + o[r]);
            return i.length ? "?" + i.join("&") : ""
        }, n.chunkQuery = function(t) {
            for (var e, n = {}, o = t.split("&"), i = 0, r = o.length; r > i; ++i) e = o[i].split("="), e[0] && (n[e[0]] = e[1]);
            return n
        };
        var r = !1;
        n.load = function(t) {
            return "document" in e && "complete" === document.readyState || r ? t() : void n.on(e, "load", t, !1)
        }, n.on = function(t, e, n, o) {
            t.attachEvent ? t.attachEvent("on" + e, n) : t.addEventListener && t.addEventListener(e, n, o)
        }, n.request = function(t) {
            if (t && "undefined" != typeof XDomainRequest && !n.ua.hasCORS) return new XDomainRequest;
            if ("undefined" != typeof XMLHttpRequest && (!t || n.ua.hasCORS)) return new XMLHttpRequest;
            if (!t) try {
                return new(window[["Active"].concat("Object").join("X")])("Microsoft.XMLHTTP")
            } catch (e) {}
            return null
        }, "undefined" != typeof window && n.load(function() {
            r = !0
        }), n.defer = function(t) {
            return n.ua.webkit && "undefined" == typeof importScripts ? void n.load(function() {
                setTimeout(t, 100)
            }) : t()
        }, n.merge = function(t, e, o, i) {
            var r, a = i || [],
                s = "undefined" == typeof o ? 2 : o;
            for (r in e) e.hasOwnProperty(r) && n.indexOf(a, r) < 0 && ("object" == typeof t[r] && s ? n.merge(t[r], e[r], s - 1, a) : (t[r] = e[r], a.push(e[r])));
            return t
        }, n.mixin = function(t, e) {
            n.merge(t.prototype, e.prototype)
        }, n.inherit = function(t, e) {
            function n() {}
            n.prototype = e.prototype, t.prototype = new n
        }, n.isArray = Array.isArray || function(t) {
            return "[object Array]" === Object.prototype.toString.call(t)
        }, n.intersect = function(t, e) {
            for (var o = [], i = t.length > e.length ? t : e, r = t.length > e.length ? e : t, a = 0, s = r.length; s > a; a++) ~n.indexOf(i, r[a]) && o.push(r[a]);
            return o
        }, n.indexOf = function(t, e, n) {
            for (var o = t.length, n = 0 > n ? 0 > n + o ? 0 : n + o : n || 0; o > n && t[n] !== e; n++);
            return n >= o ? -1 : n
        }, n.toArray = function(t) {
            for (var e = [], n = 0, o = t.length; o > n; n++) e.push(t[n]);
            return e
        }, n.ua = {}, n.ua.hasCORS = "undefined" != typeof XMLHttpRequest && function() {
            try {
                var t = new XMLHttpRequest
            } catch (e) {
                return !1
            }
            return void 0 != t.withCredentials
        }(), n.ua.webkit = "undefined" != typeof navigator && /webkit/i.test(navigator.userAgent), n.ua.iDevice = "undefined" != typeof navigator && /iPad|iPhone|iPod/i.test(navigator.userAgent)
    }("undefined" != typeof io ? io : module.exports, this),
    function(t, e) {
        function n() {}
        t.EventEmitter = n, n.prototype.on = function(t, n) {
            return this.$events || (this.$events = {}), this.$events[t] ? e.util.isArray(this.$events[t]) ? this.$events[t].push(n) : this.$events[t] = [this.$events[t], n] : this.$events[t] = n, this
        }, n.prototype.addListener = n.prototype.on, n.prototype.once = function(t, e) {
            function n() {
                o.removeListener(t, n), e.apply(this, arguments)
            }
            var o = this;
            return n.listener = e, this.on(t, n), this
        }, n.prototype.removeListener = function(t, n) {
            if (this.$events && this.$events[t]) {
                var o = this.$events[t];
                if (e.util.isArray(o)) {
                    for (var i = -1, r = 0, a = o.length; a > r; r++)
                        if (o[r] === n || o[r].listener && o[r].listener === n) {
                            i = r;
                            break
                        }
                    if (0 > i) return this;
                    o.splice(i, 1), o.length || delete this.$events[t]
                } else(o === n || o.listener && o.listener === n) && delete this.$events[t]
            }
            return this
        }, n.prototype.removeAllListeners = function(t) {
            return void 0 === t ? (this.$events = {}, this) : (this.$events && this.$events[t] && (this.$events[t] = null), this)
        }, n.prototype.listeners = function(t) {
            return this.$events || (this.$events = {}), this.$events[t] || (this.$events[t] = []), e.util.isArray(this.$events[t]) || (this.$events[t] = [this.$events[t]]), this.$events[t]
        }, n.prototype.emit = function(t) {
            if (!this.$events) return !1;
            var n = this.$events[t];
            if (!n) return !1;
            var o = Array.prototype.slice.call(arguments, 1);
            if ("function" == typeof n) n.apply(this, o);
            else {
                if (!e.util.isArray(n)) return !1;
                for (var i = n.slice(), r = 0, a = i.length; a > r; r++) i[r].apply(this, o)
            }
            return !0
        }
    }("undefined" != typeof io ? io : module.exports, "undefined" != typeof io ? io : module.parent.exports),
    function(exports, nativeJSON) {
        "use strict";

        function f(t) {
            return 10 > t ? "0" + t : t
        }

        function date(t) {
            return isFinite(t.valueOf()) ? t.getUTCFullYear() + "-" + f(t.getUTCMonth() + 1) + "-" + f(t.getUTCDate()) + "T" + f(t.getUTCHours()) + ":" + f(t.getUTCMinutes()) + ":" + f(t.getUTCSeconds()) + "Z" : null
        }

        function quote(t) {
            return escapable.lastIndex = 0, escapable.test(t) ? '"' + t.replace(escapable, function(t) {
                var e = meta[t];
                return "string" == typeof e ? e : "\\u" + ("0000" + t.charCodeAt(0).toString(16)).slice(-4)
            }) + '"' : '"' + t + '"'
        }

        function str(t, e) {
            var n, o, i, r, a, s = gap,
                c = e[t];
            switch (c instanceof Date && (c = date(t)), "function" == typeof rep && (c = rep.call(e, t, c)), typeof c) {
                case "string":
                    return quote(c);
                case "number":
                    return isFinite(c) ? String(c) : "null";
                case "boolean":
                case "null":
                    return String(c);
                case "object":
                    if (!c) return "null";
                    if (gap += indent, a = [], "[object Array]" === Object.prototype.toString.apply(c)) {
                        for (r = c.length, n = 0; r > n; n += 1) a[n] = str(n, c) || "null";
                        return i = 0 === a.length ? "[]" : gap ? "[\n" + gap + a.join(",\n" + gap) + "\n" + s + "]" : "[" + a.join(",") + "]", gap = s, i
                    }
                    if (rep && "object" == typeof rep)
                        for (r = rep.length, n = 0; r > n; n += 1) "string" == typeof rep[n] && (o = rep[n], i = str(o, c), i && a.push(quote(o) + (gap ? ": " : ":") + i));
                    else
                        for (o in c) Object.prototype.hasOwnProperty.call(c, o) && (i = str(o, c), i && a.push(quote(o) + (gap ? ": " : ":") + i));
                    return i = 0 === a.length ? "{}" : gap ? "{\n" + gap + a.join(",\n" + gap) + "\n" + s + "}" : "{" + a.join(",") + "}", gap = s, i
            }
        }
        if (nativeJSON && nativeJSON.parse) return exports.JSON = {
            parse: nativeJSON.parse,
            stringify: nativeJSON.stringify
        };
        var JSON = exports.JSON = {},
            cx = /[\u0000\u00ad\u0600-\u0604\u070f\u17b4\u17b5\u200c-\u200f\u2028-\u202f\u2060-\u206f\ufeff\ufff0-\uffff]/g,
            escapable = /[\\\"\x00-\x1f\x7f-\x9f\u00ad\u0600-\u0604\u070f\u17b4\u17b5\u200c-\u200f\u2028-\u202f\u2060-\u206f\ufeff\ufff0-\uffff]/g,
            gap, indent, meta = {
                "\b": "\\b",
                "	": "\\t",
                "\n": "\\n",
                "\f": "\\f",
                "\r": "\\r",
                '"': '\\"',
                "\\": "\\\\"
            },
            rep;
        JSON.stringify = function(t, e, n) {
            var o;
            if (gap = "", indent = "", "number" == typeof n)
                for (o = 0; n > o; o += 1) indent += " ";
            else "string" == typeof n && (indent = n);
            if (rep = e, e && "function" != typeof e && ("object" != typeof e || "number" != typeof e.length)) throw new Error("JSON.stringify");
            return str("", {
                "": t
            })
        }, JSON.parse = function(text, reviver) {
            function walk(t, e) {
                var n, o, i = t[e];
                if (i && "object" == typeof i)
                    for (n in i) Object.prototype.hasOwnProperty.call(i, n) && (o = walk(i, n), void 0 !== o ? i[n] = o : delete i[n]);
                return reviver.call(t, e, i)
            }
            var j;
            if (text = String(text), cx.lastIndex = 0, cx.test(text) && (text = text.replace(cx, function(t) {
                    return "\\u" + ("0000" + t.charCodeAt(0).toString(16)).slice(-4)
                })), /^[\],:{}\s]*$/.test(text.replace(/\\(?:["\\\/bfnrt]|u[0-9a-fA-F]{4})/g, "@").replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, "]").replace(/(?:^|:|,)(?:\s*\[)+/g, ""))) return j = eval("(" + text + ")"), "function" == typeof reviver ? walk({
                "": j
            }, "") : j;
            throw new SyntaxError("JSON.parse")
        }
    }("undefined" != typeof io ? io : module.exports, "undefined" != typeof JSON ? JSON : void 0),
    function(t, e) {
        var n = t.parser = {},
            o = n.packets = ["disconnect", "connect", "heartbeat", "message", "json", "event", "ack", "error", "noop"],
            i = n.reasons = ["transport not supported", "client not handshaken", "unauthorized"],
            r = n.advice = ["reconnect"],
            a = e.JSON,
            s = e.util.indexOf;
        n.encodePacket = function(t) {
            var e = s(o, t.type),
                n = t.id || "",
                c = t.endpoint || "",
                p = t.ack,
                l = null;
            switch (t.type) {
                case "error":
                    var u = t.reason ? s(i, t.reason) : "",
                        d = t.advice ? s(r, t.advice) : "";
                    ("" !== u || "" !== d) && (l = u + ("" !== d ? "+" + d : ""));
                    break;
                case "message":
                    "" !== t.data && (l = t.data);
                    break;
                case "event":
                    var h = {
                        name: t.name
                    };
                    t.args && t.args.length && (h.args = t.args), l = a.stringify(h);
                    break;
                case "json":
                    l = a.stringify(t.data);
                    break;
                case "connect":
                    t.qs && (l = t.qs);
                    break;
                case "ack":
                    l = t.ackId + (t.args && t.args.length ? "+" + a.stringify(t.args) : "")
            }
            var f = [e, n + ("data" == p ? "+" : ""), c];
            return null !== l && void 0 !== l && f.push(l), f.join(":")
        }, n.encodePayload = function(t) {
            var e = "";
            if (1 == t.length) return t[0];
            for (var n = 0, o = t.length; o > n; n++) {
                var i = t[n];
                e += "ГЇВїВЅ" + i.length + "ГЇВїВЅ" + t[n]
            }
            return e
        };
        var c = /([^:]+):([0-9]+)?(\+)?:([^:]+)?:?([\s\S]*)?/;
        n.decodePacket = function(t) {
            var e = t.match(c);
            if (!e) return {};
            var n = e[2] || "",
                t = e[5] || "",
                s = {
                    type: o[e[1]],
                    endpoint: e[4] || ""
                };
            switch (n && (s.id = n, s.ack = e[3] ? "data" : !0), s.type) {
                case "error":
                    var e = t.split("+");
                    s.reason = i[e[0]] || "", s.advice = r[e[1]] || "";
                    break;
                case "message":
                    s.data = t || "";
                    break;
                case "event":
                    try {
                        var p = a.parse(t);
                        s.name = p.name, s.args = p.args
                    } catch (l) {}
                    s.args = s.args || [];
                    break;
                case "json":
                    try {
                        s.data = a.parse(t)
                    } catch (l) {}
                    break;
                case "connect":
                    s.qs = t || "";
                    break;
                case "ack":
                    var e = t.match(/^([0-9]+)(\+)?(.*)/);
                    if (e && (s.ackId = e[1], s.args = [], e[3])) try {
                        s.args = e[3] ? a.parse(e[3]) : []
                    } catch (l) {}
                    break;
                case "disconnect":
                case "heartbeat":
            }
            return s
        }, n.decodePayload = function(t) {
            if ("ГЇВїВЅ" == t.charAt(0)) {
                for (var e = [], o = 1, i = ""; o < t.length; o++) "ГЇВїВЅ" == t.charAt(o) ? (e.push(n.decodePacket(t.substr(o + 1).substr(0, i))), o += Number(i) + 1, i = "") : i += t.charAt(o);
                return e
            }
            return [n.decodePacket(t)]
        }
    }("undefined" != typeof io ? io : module.exports, "undefined" != typeof io ? io : module.parent.exports),
    function(t, e) {
        function n(t, e) {
            this.socket = t, this.sessid = e
        }
        t.Transport = n, e.util.mixin(n, e.EventEmitter), n.prototype.heartbeats = function() {
            return !0
        }, n.prototype.onData = function(t) {
            if (this.clearCloseTimeout(), (this.socket.connected || this.socket.connecting || this.socket.reconnecting) && this.setCloseTimeout(), "" !== t) {
                var n = e.parser.decodePayload(t);
                if (n && n.length)
                    for (var o = 0, i = n.length; i > o; o++) this.onPacket(n[o])
            }
            return this
        }, n.prototype.onPacket = function(t) {
            return this.socket.setHeartbeatTimeout(), "heartbeat" == t.type ? this.onHeartbeat() : ("connect" == t.type && "" == t.endpoint && this.onConnect(), "error" == t.type && "reconnect" == t.advice && (this.isOpen = !1), this.socket.onPacket(t), this)
        }, n.prototype.setCloseTimeout = function() {
            if (!this.closeTimeout) {
                var t = this;
                this.closeTimeout = setTimeout(function() {
                    t.onDisconnect()
                }, this.socket.closeTimeout)
            }
        }, n.prototype.onDisconnect = function() {
            return this.isOpen && this.close(), this.clearTimeouts(), this.socket.onDisconnect(), this
        }, n.prototype.onConnect = function() {
            return this.socket.onConnect(), this
        }, n.prototype.clearCloseTimeout = function() {
            this.closeTimeout && (clearTimeout(this.closeTimeout), this.closeTimeout = null)
        }, n.prototype.clearTimeouts = function() {
            this.clearCloseTimeout(), this.reopenTimeout && clearTimeout(this.reopenTimeout)
        }, n.prototype.packet = function(t) {
            this.send(e.parser.encodePacket(t))
        }, n.prototype.onHeartbeat = function() {
            this.packet({
                type: "heartbeat"
            })
        }, n.prototype.onOpen = function() {
            this.isOpen = !0, this.clearCloseTimeout(), this.socket.onOpen()
        }, n.prototype.onClose = function() {
            this.isOpen = !1, this.socket.onClose(), this.onDisconnect()
        }, n.prototype.prepareUrl = function() {
            var t = this.socket.options;
            return this.scheme() + "://" + t.host + ":" + t.port + "/" + t.resource + "/" + e.protocol + "/" + this.name + "/" + this.sessid
        }, n.prototype.ready = function(t, e) {
            e.call(this)
        }
    }("undefined" != typeof io ? io : module.exports, "undefined" != typeof io ? io : module.parent.exports),
    function(t, e, n) {
        function o(t) {
            if (this.options = {
                    port: 80,
                    secure: !1,
                    document: "document" in n ? document : !1,
                    resource: "socket.io",
                    transports: e.transports,
                    "connect timeout": 1e4,
                    "try multiple transports": !0,
                    reconnect: !0,
                    "reconnection delay": 500,
                    "reconnection limit": 1 / 0,
                    "reopen delay": 3e3,
                    "max reconnection attempts": 10,
                    "sync disconnect on unload": !1,
                    "auto connect": !0,
                    "flash policy port": 10843,
                    manualFlush: !1
                }, e.util.merge(this.options, t), this.connected = !1, this.open = !1, this.connecting = !1, this.reconnecting = !1, this.namespaces = {}, this.buffer = [], this.doBuffer = !1, this.options["sync disconnect on unload"] && (!this.isXDomain() || e.util.ua.hasCORS)) {
                var o = this;
                e.util.on(n, "beforeunload", function() {
                    o.disconnectSync()
                }, !1)
            }
            this.options["auto connect"] && this.connect()
        }

        function i() {}
        t.Socket = o, e.util.mixin(o, e.EventEmitter), o.prototype.of = function(t) {
            return this.namespaces[t] || (this.namespaces[t] = new e.SocketNamespace(this, t), "" !== t && this.namespaces[t].packet({
                type: "connect"
            })), this.namespaces[t]
        }, o.prototype.publish = function() {
            this.emit.apply(this, arguments);
            var t;
            for (var e in this.namespaces) this.namespaces.hasOwnProperty(e) && (t = this.of(e), t.$emit.apply(t, arguments))
        }, o.prototype.handshake = function(t) {
            function n(e) {
                e instanceof Error ? (o.connecting = !1, o.onError(e.message)) : t.apply(null, e.split(":"))
            }
            var o = this,
                r = this.options,
                a = ["http" + (r.secure ? "s" : "") + ":/", r.host + ":" + r.port, r.resource, e.protocol, e.util.query(this.options.query, "t=" + +new Date)].join("/");
            if (this.isXDomain() && !e.util.ua.hasCORS) {
                var s = document.getElementsByTagName("script")[0],
                    c = document.createElement("script");
                c.src = a + "&jsonp=" + e.j.length, s.parentNode.insertBefore(c, s), e.j.push(function(t) {
                    n(t), c.parentNode.removeChild(c)
                })
            } else {
                var p = e.util.request();
                p.open("GET", a, !0), this.isXDomain() && (p.withCredentials = !0), p.onreadystatechange = function() {
                    4 == p.readyState && (p.onreadystatechange = i, 200 == p.status ? n(p.responseText) : 403 == p.status ? o.onError(p.responseText) : (o.connecting = !1, !o.reconnecting && o.onError(p.responseText)))
                }, p.send(null)
            }
        }, o.prototype.getTransport = function(t) {
            for (var n, o = t || this.transports, i = 0; n = o[i]; i++)
                if (e.Transport[n] && e.Transport[n].check(this) && (!this.isXDomain() || e.Transport[n].xdomainCheck(this))) return new e.Transport[n](this, this.sessionid);
            return null
        }, o.prototype.connect = function(t) {
            if (this.connecting) return this;
            var n = this;
            return n.connecting = !0, this.handshake(function(o, i, r, a) {
                function s(t) {
                    return n.transport && n.transport.clearTimeouts(), n.transport = n.getTransport(t), n.transport ? void n.transport.ready(n, function() {
                        n.connecting = !0, n.publish("connecting", n.transport.name), n.transport.open(), n.options["connect timeout"] && (n.connectTimeoutTimer = setTimeout(function() {
                            if (!n.connected && (n.connecting = !1, n.options["try multiple transports"])) {
                                for (var t = n.transports; t.length > 0 && t.splice(0, 1)[0] != n.transport.name;);
                                t.length ? s(t) : n.publish("connect_failed")
                            }
                        }, n.options["connect timeout"]))
                    }) : n.publish("connect_failed")
                }
                n.sessionid = o, n.closeTimeout = 1e3 * r, n.heartbeatTimeout = 1e3 * i, n.transports || (n.transports = n.origTransports = a ? e.util.intersect(a.split(","), n.options.transports) : n.options.transports), n.setHeartbeatTimeout(), s(n.transports), n.once("connect", function() {
                    clearTimeout(n.connectTimeoutTimer), t && "function" == typeof t && t()
                })
            }), this
        }, o.prototype.setHeartbeatTimeout = function() {
            if (clearTimeout(this.heartbeatTimeoutTimer), !this.transport || this.transport.heartbeats()) {
                var t = this;
                this.heartbeatTimeoutTimer = setTimeout(function() {
                    t.transport.onClose()
                }, this.heartbeatTimeout)
            }
        }, o.prototype.packet = function(t) {
            return this.connected && !this.doBuffer ? this.transport.packet(t) : this.buffer.push(t), this
        }, o.prototype.setBuffer = function(t) {
            this.doBuffer = t, !t && this.connected && this.buffer.length && (this.options.manualFlush || this.flushBuffer())
        }, o.prototype.flushBuffer = function() {
            this.transport.payload(this.buffer), this.buffer = []
        }, o.prototype.disconnect = function() {
            return (this.connected || this.connecting) && (this.open && this.of("").packet({
                type: "disconnect"
            }), this.onDisconnect("booted")), this
        }, o.prototype.disconnectSync = function() {
            var t = e.util.request(),
                n = ["http" + (this.options.secure ? "s" : "") + ":/", this.options.host + ":" + this.options.port, this.options.resource, e.protocol, "", this.sessionid].join("/") + "/?disconnect=1";
            t.open("GET", n, !1), t.send(null), this.onDisconnect("booted")
        }, o.prototype.isXDomain = function() {
            var t = n.location.port || ("https:" == n.location.protocol ? 443 : 80);
            return this.options.host !== n.location.hostname || this.options.port != t
        }, o.prototype.onConnect = function() {
            this.connected || (this.connected = !0, this.connecting = !1, this.doBuffer || this.setBuffer(!1), this.emit("connect"))
        }, o.prototype.onOpen = function() {
            this.open = !0
        }, o.prototype.onClose = function() {
            this.open = !1, clearTimeout(this.heartbeatTimeoutTimer)
        }, o.prototype.onPacket = function(t) {
            this.of(t.endpoint).onPacket(t)
        }, o.prototype.onError = function(t) {
            t && t.advice && "reconnect" === t.advice && (this.connected || this.connecting) && (this.disconnect(), this.options.reconnect && this.reconnect()), this.publish("error", t && t.reason ? t.reason : t)
        }, o.prototype.onDisconnect = function(t) {
            var e = this.connected,
                n = this.connecting;
            this.connected = !1, this.connecting = !1, this.open = !1, (e || n) && (this.transport.close(), this.transport.clearTimeouts(), e && (this.publish("disconnect", t), "booted" != t && this.options.reconnect && !this.reconnecting && this.reconnect()))
        }, o.prototype.reconnect = function() {
            function t() {
                if (n.connected) {
                    for (var t in n.namespaces) n.namespaces.hasOwnProperty(t) && "" !== t && n.namespaces[t].packet({
                        type: "connect"
                    });
                    n.publish("reconnect", n.transport.name, n.reconnectionAttempts)
                }
                clearTimeout(n.reconnectionTimer), n.removeListener("connect_failed", e), n.removeListener("connect", e), n.reconnecting = !1, delete n.reconnectionAttempts, delete n.reconnectionDelay, delete n.reconnectionTimer, delete n.redoTransports, n.options["try multiple transports"] = i
            }

            function e() {
                return n.reconnecting ? n.connected ? t() : n.connecting && n.reconnecting ? n.reconnectionTimer = setTimeout(e, 1e3) : void(n.reconnectionAttempts++ >= o ? n.redoTransports ? (n.publish("reconnect_failed"), t()) : (n.on("connect_failed", e), n.options["try multiple transports"] = !0, n.transports = n.origTransports, n.transport = n.getTransport(), n.redoTransports = !0, n.connect()) : (n.reconnectionDelay < r && (n.reconnectionDelay *= 2), n.connect(), n.publish("reconnecting", n.reconnectionDelay, n.reconnectionAttempts), n.reconnectionTimer = setTimeout(e, n.reconnectionDelay))) : void 0
            }
            this.reconnecting = !0, this.reconnectionAttempts = 0, this.reconnectionDelay = this.options["reconnection delay"];
            var n = this,
                o = this.options["max reconnection attempts"],
                i = this.options["try multiple transports"],
                r = this.options["reconnection limit"];
            this.options["try multiple transports"] = !1, this.reconnectionTimer = setTimeout(e, this.reconnectionDelay), this.on("connect", e)
        }
    }("undefined" != typeof io ? io : module.exports, "undefined" != typeof io ? io : module.parent.exports, this),
    function(t, e) {
        function n(t, e) {
            this.socket = t, this.name = e || "", this.flags = {}, this.json = new o(this, "json"), this.ackPackets = 0, this.acks = {}
        }

        function o(t, e) {
            this.namespace = t, this.name = e
        }
        t.SocketNamespace = n, e.util.mixin(n, e.EventEmitter), n.prototype.$emit = e.EventEmitter.prototype.emit, n.prototype.of = function() {
            return this.socket.of.apply(this.socket, arguments)
        }, n.prototype.packet = function(t) {
            return t.endpoint = this.name, this.socket.packet(t), this.flags = {}, this
        }, n.prototype.send = function(t, e) {
            var n = {
                type: this.flags.json ? "json" : "message",
                data: t
            };
            return "function" == typeof e && (n.id = ++this.ackPackets, n.ack = !0, this.acks[n.id] = e), this.packet(n)
        }, n.prototype.emit = function(t) {
            var e = Array.prototype.slice.call(arguments, 1),
                n = e[e.length - 1],
                o = {
                    type: "event",
                    name: t
                };
            return "function" == typeof n && (o.id = ++this.ackPackets, o.ack = "data", this.acks[o.id] = n, e = e.slice(0, e.length - 1)), o.args = e, this.packet(o)
        }, n.prototype.disconnect = function() {
            return "" === this.name ? this.socket.disconnect() : (this.packet({
                type: "disconnect"
            }), this.$emit("disconnect")), this
        }, n.prototype.onPacket = function(t) {
            function n() {
                o.packet({
                    type: "ack",
                    args: e.util.toArray(arguments),
                    ackId: t.id
                })
            }
            var o = this;
            switch (t.type) {
                case "connect":
                    this.$emit("connect");
                    break;
                case "disconnect":
                    "" === this.name ? this.socket.onDisconnect(t.reason || "booted") : this.$emit("disconnect", t.reason);
                    break;
                case "message":
                case "json":
                    var i = ["message", t.data];
                    "data" == t.ack ? i.push(n) : t.ack && this.packet({
                        type: "ack",
                        ackId: t.id
                    }), this.$emit.apply(this, i);
                    break;
                case "event":
                    var i = [t.name].concat(t.args);
                    "data" == t.ack && i.push(n), this.$emit.apply(this, i);
                    break;
                case "ack":
                    this.acks[t.ackId] && (this.acks[t.ackId].apply(this, t.args), delete this.acks[t.ackId]);
                    break;
                case "error":
                    t.advice ? this.socket.onError(t) : "unauthorized" == t.reason ? this.$emit("connect_failed", t.reason) : this.$emit("error", t.reason)
            }
        }, o.prototype.send = function() {
            this.namespace.flags[this.name] = !0, this.namespace.send.apply(this.namespace, arguments)
        }, o.prototype.emit = function() {
            this.namespace.flags[this.name] = !0, this.namespace.emit.apply(this.namespace, arguments)
        }
    }("undefined" != typeof io ? io : module.exports, "undefined" != typeof io ? io : module.parent.exports),
    function(t, e, n) {
        function o() {
            e.Transport.apply(this, arguments)
        }
        t.websocket = o, e.util.inherit(o, e.Transport), o.prototype.name = "websocket", o.prototype.open = function() {
            var t, o = e.util.query(this.socket.options.query),
                i = this;
            return t || (t = n.MozWebSocket || n.WebSocket), this.websocket = new t(this.prepareUrl() + o), this.websocket.onopen = function() {
                i.onOpen(), i.socket.setBuffer(!1)
            }, this.websocket.onmessage = function(t) {
                i.onData(t.data)
            }, this.websocket.onclose = function() {
                i.onClose(), i.socket.setBuffer(!0)
            }, this.websocket.onerror = function(t) {
                i.onError(t)
            }, this
        }, o.prototype.send = e.util.ua.iDevice ? function(t) {
            var e = this;
            return setTimeout(function() {
                e.websocket.send(t)
            }, 0), this
        } : function(t) {
            return this.websocket.send(t), this
        }, o.prototype.payload = function(t) {
            for (var e = 0, n = t.length; n > e; e++) this.packet(t[e]);
            return this
        }, o.prototype.close = function() {
            return this.websocket.close(), this
        }, o.prototype.onError = function(t) {
            this.socket.onError(t)
        }, o.prototype.scheme = function() {
            return this.socket.options.secure ? "wss" : "ws"
        }, o.check = function() {
            return "WebSocket" in n && !("__addTask" in WebSocket) || "MozWebSocket" in n
        }, o.xdomainCheck = function() {
            return !0
        }, e.transports.push("websocket")
    }("undefined" != typeof io ? io.Transport : module.exports, "undefined" != typeof io ? io : module.parent.exports, this),
    function(t, e, n) {
        function o(t) {
            t && (e.Transport.apply(this, arguments), this.sendBuffer = [])
        }

        function i() {}
        t.XHR = o, e.util.inherit(o, e.Transport), o.prototype.open = function() {
            return this.socket.setBuffer(!1), this.onOpen(), this.get(), this.setCloseTimeout(), this
        }, o.prototype.payload = function(t) {
            for (var n = [], o = 0, i = t.length; i > o; o++) n.push(e.parser.encodePacket(t[o]));
            this.send(e.parser.encodePayload(n))
        }, o.prototype.send = function(t) {
            return this.post(t), this
        }, o.prototype.post = function(t) {
            function e() {
                4 == this.readyState && (this.onreadystatechange = i, r.posting = !1, 200 == this.status ? r.socket.setBuffer(!1) : r.onClose())
            }

            function o() {
                this.onload = i, r.socket.setBuffer(!1)
            }
            var r = this;
            this.socket.setBuffer(!0), this.sendXHR = this.request("POST"), n.XDomainRequest && this.sendXHR instanceof XDomainRequest ? this.sendXHR.onload = this.sendXHR.onerror = o : this.sendXHR.onreadystatechange = e, this.sendXHR.send(t)
        }, o.prototype.close = function() {
            return this.onClose(), this
        }, o.prototype.request = function(t) {
            var n = e.util.request(this.socket.isXDomain()),
                o = e.util.query(this.socket.options.query, "t=" + +new Date);
            if (n.open(t || "GET", this.prepareUrl() + o, !0), "POST" == t) try {
                n.setRequestHeader ? n.setRequestHeader("Content-type", "text/plain;charset=UTF-8") : n.contentType = "text/plain"
            } catch (i) {}
            return n
        }, o.prototype.scheme = function() {
            return this.socket.options.secure ? "https" : "http"
        }, o.check = function(t, o) {
            try {
                var i = e.util.request(o),
                    r = n.XDomainRequest && i instanceof XDomainRequest,
                    a = t && t.options && t.options.secure ? "https:" : "http:",
                    s = n.location && a != n.location.protocol;
                if (i && (!r || !s)) return !0
            } catch (c) {}
            return !1
        }, o.xdomainCheck = function(t) {
            return o.check(t, !0)
        }
    }("undefined" != typeof io ? io.Transport : module.exports, "undefined" != typeof io ? io : module.parent.exports, this),
    function(t, e) {
        function n() {
            e.Transport.XHR.apply(this, arguments)
        }
        t.htmlfile = n, e.util.inherit(n, e.Transport.XHR), n.prototype.name = "htmlfile", n.prototype.get = function() {
            this.doc = new(window[["Active"].concat("Object").join("X")])("htmlfile"), this.doc.open(), this.doc.write("<html></html>"), this.doc.close(), this.doc.parentWindow.s = this;
            var t = this.doc.createElement("div");
            t.className = "socketio", this.doc.body.appendChild(t), this.iframe = this.doc.createElement("iframe"), t.appendChild(this.iframe);
            var n = this,
                o = e.util.query(this.socket.options.query, "t=" + +new Date);
            this.iframe.src = this.prepareUrl() + o, e.util.on(window, "unload", function() {
                n.destroy()
            })
        }, n.prototype._ = function(t, e) {
            t = t.replace(/\\\//g, "/"), this.onData(t);
            try {
                var n = e.getElementsByTagName("script")[0];
                n.parentNode.removeChild(n)
            } catch (o) {}
        }, n.prototype.destroy = function() {
            if (this.iframe) {
                try {
                    this.iframe.src = "about:blank"
                } catch (t) {}
                this.doc = null, this.iframe.parentNode.removeChild(this.iframe), this.iframe = null, CollectGarbage()
            }
        }, n.prototype.close = function() {
            return this.destroy(), e.Transport.XHR.prototype.close.call(this)
        }, n.check = function(t) {
            if ("undefined" != typeof window && ["Active"].concat("Object").join("X") in window) try {
                var n = new(window[["Active"].concat("Object").join("X")])("htmlfile");
                return n && e.Transport.XHR.check(t)
            } catch (o) {}
            return !1
        }, n.xdomainCheck = function() {
            return !1
        }, e.transports.push("htmlfile")
    }("undefined" != typeof io ? io.Transport : module.exports, "undefined" != typeof io ? io : module.parent.exports),
    function(t, e, n) {
        function o() {
            e.Transport.XHR.apply(this, arguments)
        }

        function i() {}
        t["xhr-polling"] = o, e.util.inherit(o, e.Transport.XHR), e.util.merge(o, e.Transport.XHR), o.prototype.name = "xhr-polling", o.prototype.heartbeats = function() {
            return !1
        }, o.prototype.open = function() {
            var t = this;
            return e.Transport.XHR.prototype.open.call(t), !1
        }, o.prototype.get = function() {
            function t() {
                4 == this.readyState && (this.onreadystatechange = i, 200 == this.status ? (r.onData(this.responseText), r.get()) : r.onClose())
            }

            function e() {
                this.onload = i, this.onerror = i, r.retryCounter = 1, r.onData(this.responseText), r.get()
            }

            function o() {
                r.retryCounter++, !r.retryCounter || r.retryCounter > 3 ? r.onClose() : r.get()
            }
            if (this.isOpen) {
                var r = this;
                this.xhr = this.request(), n.XDomainRequest && this.xhr instanceof XDomainRequest ? (this.xhr.onload = e, this.xhr.onerror = o) : this.xhr.onreadystatechange = t, this.xhr.send(null)
            }
        }, o.prototype.onClose = function() {
            if (e.Transport.XHR.prototype.onClose.call(this), this.xhr) {
                this.xhr.onreadystatechange = this.xhr.onload = this.xhr.onerror = i;
                try {
                    this.xhr.abort()
                } catch (t) {}
                this.xhr = null
            }
        }, o.prototype.ready = function(t, n) {
            var o = this;
            e.util.defer(function() {
                n.call(o)
            })
        }, e.transports.push("xhr-polling")
    }("undefined" != typeof io ? io.Transport : module.exports, "undefined" != typeof io ? io : module.parent.exports, this),
    function(t, e, n) {
        function o() {
            e.Transport["xhr-polling"].apply(this, arguments), this.index = e.j.length;
            var t = this;
            e.j.push(function(e) {
                t._(e)
            })
        }
        var i = n.document && "MozAppearance" in n.document.documentElement.style;
        t["jsonp-polling"] = o, e.util.inherit(o, e.Transport["xhr-polling"]), o.prototype.name = "jsonp-polling", o.prototype.post = function(t) {
            function n() {
                o(), i.socket.setBuffer(!1)
            }

            function o() {
                i.iframe && i.form.removeChild(i.iframe);
                try {
                    a = document.createElement('<iframe name="' + i.iframeId + '">')
                } catch (t) {
                    a = document.createElement("iframe"), a.name = i.iframeId
                }
                a.id = i.iframeId, i.form.appendChild(a), i.iframe = a
            }
            var i = this,
                r = e.util.query(this.socket.options.query, "t=" + +new Date + "&i=" + this.index);
            if (!this.form) {
                var a, s = document.createElement("form"),
                    c = document.createElement("textarea"),
                    p = this.iframeId = "socketio_iframe_" + this.index;
                s.className = "socketio", s.style.position = "absolute", s.style.top = "0px", s.style.left = "0px", s.style.display = "none", s.target = p, s.method = "POST", s.setAttribute("accept-charset", "utf-8"), c.name = "d", s.appendChild(c), document.body.appendChild(s), this.form = s, this.area = c
            }
            this.form.action = this.prepareUrl() + r, o(), this.area.value = e.JSON.stringify(t);
            try {
                this.form.submit()
            } catch (l) {}
            this.iframe.attachEvent ? a.onreadystatechange = function() {
                "complete" == i.iframe.readyState && n()
            } : this.iframe.onload = n, this.socket.setBuffer(!0)
        }, o.prototype.get = function() {
            var t = this,
                n = document.createElement("script"),
                o = e.util.query(this.socket.options.query, "t=" + +new Date + "&i=" + this.index);
            this.script && (this.script.parentNode.removeChild(this.script), this.script = null), n.async = !0, n.src = this.prepareUrl() + o, n.onerror = function() {
                t.onClose()
            };
            var r = document.getElementsByTagName("script")[0];
            r.parentNode.insertBefore(n, r), this.script = n, i && setTimeout(function() {
                var t = document.createElement("iframe");
                document.body.appendChild(t), document.body.removeChild(t)
            }, 100)
        }, o.prototype._ = function(t) {
            return this.onData(t), this.isOpen && this.get(), this
        }, o.prototype.ready = function(t, n) {
            var o = this;
            return i ? void e.util.load(function() {
                n.call(o)
            }) : n.call(this)
        }, o.check = function() {
            return "document" in n
        }, o.xdomainCheck = function() {
            return !0
        }, e.transports.push("jsonp-polling")
    }("undefined" != typeof io ? io.Transport : module.exports, "undefined" != typeof io ? io : module.parent.exports, this), "function" == typeof define && define.amd && define([], function() {
        return io
    })
}();