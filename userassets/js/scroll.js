//Plugin
var customScroll = function() {
    var a = { barSize: "0" },
        b = { anchorScrollSpeed: 10, pageScrollSpeed: 20, clientX: 0, clientY: 0, type: { 0: "vertical", 1: "horizontal" }, vertical: { cSize: "clientHeight", func: "height", css1: "top", css2: "height", sSize: "scrollHeight", sStart: "scrollTop" }, horizontal: { cSize: "clientWidth", func: "width", css1: "left", css2: "width", sSize: "scrollWidth", sStart: "scrollLeft" } },
        c = function() {
            var a = function(a, c, e, f) {
                    var g = e.scrollToward,
                        h = 0,
                        i = e[a].bar[0];
                    if (c.hasClass("anchor")) { h = b.anchorScrollSpeed; var j = c.hasClass("head") ? -h : h } else {
                        var k = e[a].bar[0].getBoundingClientRect(),
                            l = ("vertical" == a ? f.clientY < k.top : f.clientX < k.left) ? "head" : "foot";
                        h = b.pageScrollSpeed;
                        var j = "head" == l ? -h : h
                    }
                    g.interval = setInterval(function() { return document.elementFromPoint(b.clientX, b.clientY) == i ? void clearInterval(d.scrollToward.interval) : void e.scrollToward(a, j) }, 100)
                },
                c = function(a, c) { b.drag = { dir: a, obj: c, prev_clientX: b.clientX, prev_clientY: b.clientY } },
                e = function(b) {
                    var d = this;
                    this[b].scroll.mousedown(function(b, e) {
                        var f = $(b.target || b.srcElement);
                        e = f.hasClass("bar") || f.hasClass("anchor") ? f.parent().attr("class").match(/vertical|horizontal/) : f.attr("class").match(/vertical|horizontal/), f.hasClass("bar") ? c(e, d) : a(e, f, d, b), b.preventDefault()
                    }).click(function(a) { a.stopPropagation() })
                };
            return { mouseEvents: e }
        },
        d = {
            type: { 0: "vertical", 1: "horizontal" },
            injectStructure: function() {
                function a(a) { this[a] = { scroll: $("<div>").addClass("csb matchParent " + a), head: $("<div>").addClass("matchParent anchor head"), foot: $("<div>").addClass("matchParent anchor foot"), bar: $("<div>").addClass("bar") }, this[a].scroll.append(this[a].head).append(this[a].bar).append(this[a].foot), this.cover.append(this[a].scroll), this.anchorSize = this[a].head[this.getProperty(a, "func")](), this[a].bar[0].style[this.getProperty(a, "css1")] = this.anchorSize + "px" }
                for (var b = document.createDocumentFragment(), c = this.elem[0].childNodes; c.length;) b.appendChild(c[0]);
                this.cover = $("<div>").addClass("cover"), this.content = $("<div>").addClass("matchParent content"), this.content.append($(b));
                var d = { minWidth: this.elem.css("min-width"), maxWidth: this.elem.css("max-width"), minHeight: this.elem.css("min-height"), maxHeight: this.elem.css("max-height") };
                this.content.css(d), this.cover[0].setAttribute("onscroll", "this.scrollLeft=this.scrollTop=0"), this.cover.append(this.content), this.elem.append(this.cover), a.call(this, this.type[0]), a.call(this, this.type[1])
            },
            getPaneSize: function(a) {
                var b = this.getProperty(a, "func"),
                    c = this[a].head[b](),
                    d = this[a].scroll[b]() - 2 * c;
                return { aSize: c, pSize: d > -1 ? d : 0 }
            },
            setRatio: function(a) {
                var b = (this.getProperty(a, "css1"), this.getProperty(a, "css2")),
                    c = this.getProperty(a, "sSize"),
                    d = this.getProperty(a, "sStart"),
                    e = this.getPaneSize(a),
                    f = Math.max(this.params.barSize, Math.pow(e.pSize, 2) / this.content[0][c]);
                this[a].bar[0].style[b] = f + "px";
                var g = this.content[0][d];
                this.content[0][d] = this.content[0][c], this[a].maxsSize = this.content[0][d], this.content[0][d] = g, this[a].RATIO = 0 != this[a].maxsSize ? (e.pSize - f) / this[a].maxsSize : 0
            },
            isScrollable: function(a) {
                var b = this.getProperty(a, "sSize");
                b = this.content[0][b];
                var c = this.getProperty(a, "cSize");
                return c = this.content[0][c], b > c
            },
            show: function(a) { var c = a ? { 0: a } : b.type; for (key in c) a = c[key], this.isScrollable(a) ? (this[a].scroll.stop(!0, !0), this[a].scroll.fadeIn("slow")) : this.hide(a) },
            hide: function(a) { var c = a ? { 0: a } : b.type; for (key in c) a = c[key], this[a].scroll.stop(!0, !0), this[a].scroll.fadeOut("slow") },
            onScrollSizeUpdate: function(a) { this.setRatio(a), this.show() },
            setBarStart: function(a, b) {
                {
                    var c = this.getProperty(a, "css1");
                    this.getProperty(a, "func")
                }
                b = b * this[a].RATIO + this.anchorSize, this[a].bar[0].style[c] = b + "px"
            },
            onScrollChange: function() {
                if (!this.synching) {
                    this.synching = !0;
                    var a = this.getProperty("type");
                    for (key in a) {
                        var b = a[key],
                            c = this[b]._sSize || 0,
                            d = this[b]._sStart || 0,
                            e = this[b]._cSize || 0,
                            f = this.content[0][this.getProperty(b, "cSize")];
                        e != f && (this.onScrollSizeUpdate(b), this[b]._cSize = f);
                        var g = this.content[0][this.getProperty(b, "sSize")];
                        c != g && (this.onScrollSizeUpdate(b), this[b]._sSize = g);
                        var h = this.content[0][this.getProperty(b, "sStart")];
                        d != h && (this.setBarStart(b, h), this[b]._sStart = h)
                    }
                    this.synching = !1
                }
            },
            getProperty: function(a, c) { return c ? b[a][c] : b[a] },
            scrollTo: function(a, b) {
                var c = this.getProperty(a, "sStart");
                this.content[0][c] = b
            },
            scrollToward: function(a, b) {
                {
                    var c = this.getProperty(a, "sStart");
                    this.content[0][c]
                }
                this.content[0][c] += b
            },
            attachEvents: function() {
                var a = this,
                    c = b.type;
                for (key in c) {
                    var d = c[key];
                    this.mouseEvents(d)
                }
                this.onScrollChange(), this.content.on("scroll	", function() { a.onScrollChange() }), this.cover.mouseenter(function() { a.show() }).mouseleave(function() { b.drag || a.hide() })
            }
        },
        e = function(a, b) { a.csb = { reset: function() { b.onScrollChange() }, scrollToHead: function() {}, scrollToHead: function() {}, scrollTo: function() {}, remove: function() {} } },
        f = function(b, c) { this.elem = b, this.params = $.extend({}, a, c), this.injectStructure(), this.attachEvents(), e(b[0], this) },
        g = c();
    for (key in g) d[key] = g[key];
    f.prototype = d;
    var h = function(a) {
        for (var b = $(".nScroll"), c = b.length - 1; c > -1; c--) b.eq(c).css({ overflow: "visisble" }), new f(b.eq(c), a);
        b.removeClass("nScroll").addClass("nScrollable")
    };
    return $(document).on("mouseup", function() { b.drag = null, clearInterval(d.scrollToward.interval) }).on("mousemove", function(a) {
        if (b.clientX = a.clientX, b.clientY = a.clientY, b.drag) {
            var c = b.clientX - b.drag.prev_clientX,
                d = b.clientY - b.drag.prev_clientY,
                e = b.drag.obj,
                f = b.drag.dir,
                g = ("vertical" == f ? d : c) / e[f].RATIO;
            e.scrollToward(b.drag.dir, g), b.drag.prev_clientX = b.clientX, b.drag.prev_clientY = b.clientY
        }
    }), { init: h }
}();

//Event binding
$('#toggle').click(function() {
    $('#hidden').toggle();
    toggler.csb.reset();
});

//Call
customScroll.init();