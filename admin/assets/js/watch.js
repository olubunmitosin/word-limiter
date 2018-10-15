(function(n, t) {
    n.fn.watch = function(i) {
        function u(t, i, u) {
            t.each(function() {
                var i = n(this),
                    t;
                window.MutationObserver ? (t = i.data("__watcherObserver" + r.id), t == null && (t = new MutationObserver(u.fnc), i.data("__watcherObserver" + r.id, t)), t.observe(this, {
                    attributes: !0,
                    subtree: r.watchChildren,
                    childList: r.watchChildren,
                    characterData: !0
                })) : u.intervalId = setInterval(u.fnc, r.interval)
            })
        }

        function f(i, r, f) {
            var s = n(this),
                e = s.data(i),
                a, l, o, h, c;
            if (e && (a = this, e.func)) {
                for (l = !1, o = 0, o; o < e.props.length; o++)
                    if ((h = e.props[o], c = "", c = h.startsWith("attr_") ? s.attr(h.replace("attr_", "")) : h.startsWith("prop_") ? s.prop(h.replace("prop_", "")) : s.css(h), c != t) && e.vals[o] != c) {
                        e.vals[o] = c;
                        l = !0;
                        break
                    }
                l && (s.unwatch(i), e.func.call(a, e, o, r, f), u(s, i, e))
            }
        }
        var r = n.extend({
            properties: null,
            interval: 100,
            id: "_watcher_" + (new Date).getTime(),
            watchChildren: !1,
            callback: null
        }, i);
        return this.each(function() {
            var e = this,
                i = n(this),
                o = function(n, t) {
                    f.call(e, r.id, n, t)
                },
                t = {
                    id: r.id,
                    props: r.properties.split(","),
                    vals: [r.properties.split(",").length],
                    func: r.callback,
                    fnc: o,
                    origProps: r.properties,
                    interval: r.interval,
                    intervalId: null
                };
            n.each(t.props, function(n) {
                var r = t.props[n];
                t.vals[n] = t.props[n].startsWith("attr_") ? i.attr(r.replace("attr_", "")) : r.startsWith("prop_") ? i.prop(r.replace("props_", "")) : i.css(r)
            });
            i.data(r.id, t);
            u(i, r.id, t)
        })
    };
    n.fn.unwatch = function(t) {
        return this.each(function() {
            var i = n(this),
                u = i.data(t),
                r;
            try {
                window.MutationObserver ? (r = i.data("__watcherObserver" + t), r && (r.disconnect(), i.removeData("__watcherObserver" + t))) : clearInterval(u.intervalId)
            } catch (f) {}
        }), this
    };
    String.prototype.startsWith = function(n) {
        return n === null || n === t ? !1 : n == this.substr(0, n.length)
    }
})(jQuery, undefined);