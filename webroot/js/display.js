
var UTIL = function() {

    function e(e) {
        if (g || t()) g = !0, e();
        else {
            var n = function() {
                t() && (g = !0, window.removeEventListener("load", e), document.removeEventListener("readystatechange", n), e())
            };
            document.addEventListener("readystatechange", n), window.addEventListener("load", e)
        }
    }
	
    function t() {
        return "complete" === document.readyState || "loading" !== document.readyState && !document.documentElement.doScroll
    }
    

    function n(e, t) {
        e.classList ? e.classList.add(t) : e.className += " " + t
    }

    function a(e, t) {
        e.classList ? e.classList.remove(t) : e.className = e.className.replace(new RegExp("(^|\\b)" + t.split(" ").join("|") + "(\\b|$)", "gi"), " ")
    }

    function s(e, t) {
        return e.classList ? e.classList.contains(t) : new RegExp("(^| )" + t + "( |$)", "gi").test(e.className)
    }

    function r(e) {
        try {
            var t = new CustomEvent(e)
        } catch (n) {
            var t = document.createEvent("CustomEvent");
            t.initCustomEvent(e, !0, !0, null)
        }
        document.dispatchEvent(t)
    }

    function o() {
        return null === h || void 0 === h ? h = document.querySelector('meta[name="csrf-token"]').getAttribute("content") : h
    }

    function i(e) {
        var t = new XMLHttpRequest;
        return t.open("GET", e, !0), t.setRequestHeader("X-CSRF-Token", o()), t.setRequestHeader("Accept", "text/javascript, application/javascript, application/ecmascript, application/x-ecmascript, */*; q=0.01"), t.setRequestHeader("X-Requested-With", "XMLHttpRequest"), t
    }

    function d(e, t, n) {
        var a = new XMLHttpRequest;
        return a.open("GET", e, !0), a.setRequestHeader("X-CSRF-Token", o()), a.onreadystatechange = function() {
            4 === a.readyState && (a.status >= 200 && a.status < 400 ? t(a.responseText) : n(a.responseText))
        }, a.send(), a
    }

    function l(e) {
        u = e
    }

    function c() {
        return u || !1
    }
    var u, g = !1;
    return {
        ready: e,
        addClass: n,
        removeClass: a,
        hasClass: s,
        triggerEvent: r,
        getCsrfToken: o,
        scriptRequest: i,
        getRequest: d,
        setSignedIn: l,
        isSignedIn: c
    };
    var h
}();

var rowGrid = function(e, t) {
    function n(e) {
        for (var t = [e];
            (e = e.nextSibling) && 9 !== e.nodeType;) 1 === e.nodeType && t.push(e);
        return t
    }

    function a(e, t, n) {
        for (var a, s, r, o = 0, i = [], n = Array.prototype.slice.call(n || e.querySelectorAll(t.itemSelector)), d = n.length, l = getComputedStyle(e), c = Math.floor(e.getBoundingClientRect().width) - parseFloat(l.getPropertyValue("padding-left")) - parseFloat(l.getPropertyValue("padding-right")), u = [], g = 0; d > g; ++g) a = n[g].getElementsByTagName("img")[0], a ? ((s = parseInt(a.getAttribute("width"))) || a.setAttribute("width", s = a.offsetWidth), (r = parseInt(a.getAttribute("height"))) || a.setAttribute("height", r = a.offsetHeight), u[g] = {
            width: s,
            height: r
        }) : (n.splice(g, 1), --g, --d);
        d = n.length;
        for (var h = 0; d > h; ++h) {
            if (n[h].classList ? (n[h].classList.remove(t.firstItemClass), n[h].classList.remove(t.lastRowClass)) : n[h].className = n[h].className.replace(new RegExp("(^|\\b)" + t.firstItemClass + "|" + t.lastRowClass + "(\\b|$)", "gi"), " "), o += u[h].width, i.push(n[h]), h === d - 1)
                for (var f = 0; f < i.length; f++) {
                    0 === f && (i[f].className += " " + t.lastRowClass);
                    var m = "width: " + u[h + parseInt(f) - i.length + 1].width + "px;height: " + u[h + parseInt(f) - i.length + 1].height + "px;";
                    f < i.length - 1 && (m += "margin-right:" + t.minMargin + "px"), i[f].style.cssText = m
                }
            if (o + t.maxMargin * (i.length - 1) > c || window.innerWidth < t.minWidth) {
                var p = o + t.maxMargin * (i.length - 1) - c,
                    v = i.length,
                    T = (t.maxMargin - t.minMargin) * (v - 1);
                if (p > T) {
                    var L = t.minMargin;
                    p -= (t.maxMargin - t.minMargin) * (v - 1)
                } else {
                    var L = t.maxMargin - p / (v - 1);
                    p = 0
                }
                for (var E, y = null, S = 0, f = 0; f < i.length; f++) {
                    E = i[f];
                    var O = u[h + parseInt(f) - i.length + 1].width,
                        b = O - O / o * p;
                    y = y || Math.round(u[h + parseInt(f) - i.length + 1].height * (b / O)), S + 1 - b % 1 >= .5 ? (S -= b % 1, b = Math.floor(b)) : (S += 1 - b % 1, b = Math.ceil(b));
                    var m = "width: " + b + "px;height: " + y + "px;";
                    f < i.length - 1 && (m += "margin-right: " + L + "px"), E.style.cssText = m, 0 === f && t.firstItemClass && (E.className += " " + t.firstItemClass)
                }
                i = [], o = 0
            }
        }
    }
    if (null !== e && void 0 !== e)
        if ("appended" === t) {
            t = JSON.parse(e.getAttribute("data-row-grid"));
            var s = e.getElementsByClassName(t.lastRowClass)[0],
                r = n(s);
            a(e, t, r)
        } else t ? (void 0 === t.resize && (t.resize = !0), void 0 === t.minWidth && (t.minWidth = 0), void 0 === t.lastRowClass && (t.lastRowClass = "last-row")) : t = JSON.parse(e.getAttribute("data-row-grid")), a(e, t), e.setAttribute("data-row-grid", JSON.stringify(t)), t.resize && window.addEventListener("resize", function(n) {
            a(e, t)
        })
};

! function() {
    function e() {
        var e = {
            minMargin: 5,
            maxMargin: 5,
            itemSelector: ".photo-item",
            firstItemClass: "first-item",
            lastRowClass: "last-row",
            resize: !0,
            minWidth: 426
        };
        rowGrid(document.getElementsByClassName("photos")[0], e)
    }
    UTIL.ready(e)
}();