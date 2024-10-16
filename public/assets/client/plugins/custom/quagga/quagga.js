!function(n, e) {
    "object" == typeof exports && "undefined" != typeof module ? module.exports = e(require("jimp")) : "function" == typeof define && define.amd ? define(["jimp"], e) : (n = "undefined" != typeof globalThis ? globalThis : n || self).javascriptBarcodeReader = e(n.Jimp)
}(this, (function(n) {
    "use strict";
    function e(n) {
        if (n && n.__esModule)
            return n;
        var e = Object.create(null);
        return n && Object.keys(n).forEach((function(t) {
            if ("default" !== t) {
                var o = Object.getOwnPropertyDescriptor(n, t);
                Object.defineProperty(e, t, o.get ? o : {
                    enumerable: !0,
                    get: function() {
                        return n[t]
                    }
                })
            }
        }
        )),
        e.default = n,
        Object.freeze(e)
    }
    var t = e(n);
    /*! *****************************************************************************
    Copyright (c) Microsoft Corporation.

    Permission to use, copy, modify, and/or distribute this software for any
    purpose with or without fee is hereby granted.

    THE SOFTWARE IS PROVIDED "AS IS" AND THE AUTHOR DISCLAIMS ALL WARRANTIES WITH
    REGARD TO THIS SOFTWARE INCLUDING ALL IMPLIED WARRANTIES OF MERCHANTABILITY
    AND FITNESS. IN NO EVENT SHALL THE AUTHOR BE LIABLE FOR ANY SPECIAL, DIRECT,
    INDIRECT, OR CONSEQUENTIAL DAMAGES OR ANY DAMAGES WHATSOEVER RESULTING FROM
    LOSS OF USE, DATA OR PROFITS, WHETHER IN AN ACTION OF CONTRACT, NEGLIGENCE OR
    OTHER TORTIOUS ACTION, ARISING OUT OF OR IN CONNECTION WITH THE USE OR
    PERFORMANCE OF THIS SOFTWARE.
    ***************************************************************************** */
    function o(n, e, t, o) {
        return new (t || (t = Promise))((function(w, r) {
            function c(n) {
                try {
                    s(o.next(n))
                } catch (n) {
                    r(n)
                }
            }
            function i(n) {
                try {
                    s(o.throw(n))
                } catch (n) {
                    r(n)
                }
            }
            function s(n) {
                var e;
                n.done ? w(n.value) : (e = n.value,
                e instanceof t ? e : new t((function(n) {
                    n(e)
                }
                ))).then(c, i)
            }
            s((o = o.apply(n, e || [])).next())
        }
        ))
    }
    const w = {
        nnnnnww: "0",
        nnnnwwn: "1",
        nnnwnnw: "2",
        wwnnnnn: "3",
        nnwnnwn: "4",
        wnnnnwn: "5",
        nwnnnnw: "6",
        nwnnwnn: "7",
        nwwnnnn: "8",
        wnnwnnn: "9",
        nnnwwnn: "-",
        nnwwnnn: "$",
        wnnnwnw: ":",
        wnwnnnw: "/",
        wnwnwnn: ".",
        nnwwwww: "+",
        nnwwnwn: "A",
        nnnwnww: "B",
        nwnwnnw: "C",
        nnnwwwn: "D"
    };
    function r(n) {
        const e = []
          , t = Math.ceil(n.reduce(( (n, e) => (n + e) / 2), 0));
        for (; n.length > 0; ) {
            const o = n.splice(0, 8).splice(0, 7).map((n => n < t ? "n" : "w")).join("");
            e.push(w[o])
        }
        return e.join("")
    }
    const c = ["212222", "222122", "222221", "121223", "121322", "131222", "122213", "122312", "132212", "221213", "221312", "231212", "112232", "122132", "122231", "113222", "123122", "123221", "223211", "221132", "221231", "213212", "223112", "312131", "311222", "321122", "321221", "312212", "322112", "322211", "212123", "212321", "232121", "111323", "131123", "131321", "112313", "132113", "132311", "211313", "231113", "231311", "112133", "112331", "132131", "113123", "113321", "133121", "313121", "211331", "231131", "213113", "213311", "213131", "311123", "311321", "331121", "312113", "312311", "332111", "314111", "221411", "431111", "111224", "111422", "121124", "121421", "141122", "141221", "112214", "112412", "122114", "122411", "142112", "142211", "241211", "221114", "413111", "241112", "134111", "111242", "121142", "121241", "114212", "124112", "124211", "411212", "421112", "421211", "212141", "214121", "412121", "111143", "111341", "131141", "114113", "114311", "411113", "411311", "113141", "114131", "311141", "411131", "211412", "211214", "211232", "233111", "211133", "2331112"]
      , i = [" ", "!", '"', "#", "$", "%", "&", "'", "(", ")", "*", "+", ",", "-", ".", "/", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9", ":", ";", "<", "=", ">", "?", "@", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "[", "\\", "]", "^", "_", "NUL", "SOH", "STX", "ETX", "EOT", "ENQ", "ACK", "BEL", "BS", "HT", "LF", "VT", "FF", "CR", "SO", "SI", "DLE", "DC1", "DC2", "DC3", "DC4", "NAK", "SYN", "ETB", "CAN", "EM", "SUB", "ESC", "FS", "GS", "RS", "US", "FNC 3", "FNC 2", "Shift B", "Code C", "Code B", "FNC 4", "FNC 1", "Code A", "Code B", "Code C", "Stop", "Reverse Stop"]
      , s = [" ", "!", '"', "#", "$", "%", "&", "'", "(", ")", "*", "+", ",", "-", ".", "/", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9", ":", ";", "<", "=", ">", "?", "@", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "[", "\\", "]", "^", "_", "`", "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z", "{", "|", "}", "~", "DEL", "FNC 3", "FNC 2", "Shift A", "Code C", "FNC 4", "Code A", "FNC 1", "Code A", "Code B", "Code C", "Stop", "Reverse Stop"]
      , a = ["00", "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31", "32", "33", "34", "35", "36", "37", "38", "39", "40", "41", "42", "43", "44", "45", "46", "47", "48", "49", "50", "51", "52", "53", "54", "55", "56", "57", "58", "59", "60", "61", "62", "63", "64", "65", "66", "67", "68", "69", "70", "71", "72", "73", "74", "75", "76", "77", "78", "79", "80", "81", "82", "83", "84", "85", "86", "87", "88", "89", "90", "91", "92", "93", "94", "95", "96", "97", "98", "99", "Code B", "Code A", "FNC 1", "Code A", "Code B", "Code C", "Stop", "Reverse Stop"];
    function l(n) {
        const e = [];
        let t, o, w = s;
        const r = (n => {
            const e = n.length - 13
              , t = n.reduce(( (n, t, o) => o >= e ? n : n + t), 0) / (11 * Math.ceil(e / 6));
            return n.map((n => Math.round(n / t) || 1))
        }
        )(n);
        if (!r)
            return "";
        r.pop();
        for (let n = 0; 6 * n < r.length - 13; n += 1) {
            t = r.slice(6 * n, 6 * (n + 1)).join("");
            const l = w[c.indexOf(t)];
            switch (l) {
            case "Code A":
                w = i;
                break;
            case "Code B":
                w = s;
                break;
            case "Code C":
                w = a;
                break;
            case "FNC 4":
                break;
            default:
                l ? ("FNC 4" === o ? e.push(l.charCodeAt(0) + 128) : e.push(l),
                o = l) : e.push("?")
            }
        }
        return e.join("")
    }
    const f = {
        nnnwwnwnn: "0",
        wnnwnnnnw: "1",
        nnwwnnnnw: "2",
        wnwwnnnnn: "3",
        nnnwwnnnw: "4",
        wnnwwnnnn: "5",
        nnwwwnnnn: "6",
        nnnwnnwnw: "7",
        wnnwnnwnn: "8",
        nnwwnnwnn: "9",
        wnnnnwnnw: "A",
        nnwnnwnnw: "B",
        wnwnnwnnn: "C",
        nnnnwwnnw: "D",
        wnnnwwnnn: "E",
        nnwnwwnnn: "F",
        nnnnnwwnw: "G",
        wnnnnwwnn: "H",
        nnwnnwwnn: "I",
        nnnnwwwnn: "J",
        wnnnnnnww: "K",
        nnwnnnnww: "L",
        wnwnnnnwn: "M",
        nnnnwnnww: "N",
        wnnnwnnwn: "O",
        nnwnwnnwn: "P",
        nnnnnnwww: "Q",
        wnnnnnwwn: "R",
        nnwnnnwwn: "S",
        nnnnwnwwn: "T",
        wwnnnnnnw: "U",
        nwwnnnnnw: "V",
        wwwnnnnnn: "W",
        nwnnwnnnw: "X",
        wwnnwnnnn: "Y",
        nwwnwnnnn: "Z",
        nwnnnnwnw: "-",
        wwnnnnwnn: ".",
        nwwnnnwnn: " ",
        nwnwnwnnn: "$",
        nwnwnnnwn: "/",
        nwnnnwnwn: "+",
        nnnwnwnwn: "%",
        nwnnwnwnn: "*"
    };
    function d(n) {
        const e = []
          , t = Math.ceil(n.reduce(( (n, e) => n + e), 0) / n.length);
        for (; n.length > 0; ) {
            const o = n.splice(0, 10).map((n => n > t ? "w" : "n")).slice(0, 9).join("");
            e.push(f[o])
        }
        return "*" !== e.pop() || "*" !== e.shift() ? "" : e.join("")
    }
    const h = [{
        100010100: "0"
    }, {
        101001e3: "1"
    }, {
        101000100: "2"
    }, {
        101000010: "3"
    }, {
        100101e3: "4"
    }, {
        100100100: "5"
    }, {
        100100010: "6"
    }, {
        10101e4: "7"
    }, {
        100010010: "8"
    }, {
        100001010: "9"
    }, {
        110101e3: "A"
    }, {
        110100100: "B"
    }, {
        110100010: "C"
    }, {
        110010100: "D"
    }, {
        110010010: "E"
    }, {
        110001010: "F"
    }, {
        101101e3: "G"
    }, {
        101100100: "H"
    }, {
        101100010: "I"
    }, {
        100110100: "J"
    }, {
        100011010: "K"
    }, {
        101011e3: "L"
    }, {
        101001100: "M"
    }, {
        101000110: "N"
    }, {
        100101100: "O"
    }, {
        100010110: "P"
    }, {
        110110100: "Q"
    }, {
        110110010: "R"
    }, {
        110101100: "S"
    }, {
        110100110: "T"
    }, {
        110010110: "U"
    }, {
        110011010: "V"
    }, {
        101101100: "W"
    }, {
        101100110: "X"
    }, {
        100110110: "Y"
    }, {
        100111010: "Z"
    }, {
        100101110: "-"
    }, {
        111010100: "."
    }, {
        111010010: " "
    }, {
        111001010: "$"
    }, {
        101101110: "/"
    }, {
        101110110: "+"
    }, {
        110101110: "%"
    }, {
        100100110: "($)"
    }, {
        111011010: "(%)"
    }, {
        111010110: "(/)"
    }, {
        100110010: "(+)"
    }, {
        101011110: "*"
    }];
    function u(n) {
        const e = []
          , t = [];
        n.pop();
        const o = Math.ceil(n.reduce(( (n, e) => n + e), 0) / n.length)
          , w = Math.ceil(n.reduce(( (n, e) => e < o ? (n + e) / 2 : n), 0));
        for (let e = 0; e < n.length; e += 1) {
            let o = n[e];
            for (; o > 0; )
                e % 2 == 0 ? t.push(1) : t.push(0),
                o -= w
        }
        for (let n = 0; n < t.length; n += 9) {
            const o = t.slice(n, n + 9).join("")
              , w = h.filter((n => Object.keys(n)[0] === o));
            e.push(w[0][o])
        }
        if ("*" !== e.shift() || "*" !== e.pop())
            return "";
        const r = e.pop();
        let c, i, s = 0;
        const a = n => Object.values(n)[0] === c;
        for (let n = e.length - 1; n >= 0; n -= 1)
            c = e[n],
            i = h.indexOf(h.filter(a)[0]),
            s += i * (1 + (e.length - (n + 1)) % 20);
        if (Object.values(h[s % 47])[0] !== r)
            return "";
        const l = e.pop();
        s = 0;
        for (let n = e.length - 1; n >= 0; n -= 1)
            c = e[n],
            i = h.indexOf(h.filter(a)[0]),
            s += i * (1 + (e.length - (n + 1)) % 20);
        return Object.values(h[s % 47])[0] !== l ? "" : e.join("")
    }
    const p = ["nnwwn", "wnnnw", "nwnnw", "wwnnn", "nnwnw", "wnwnn", "nwwnn", "nnnww", "wnnwn", "nwnwn"];
    function C(n, e) {
        const t = []
          , o = Math.ceil(n.reduce(( (n, e) => (n + e) / 2), 0));
        if ("interleaved" === e) {
            const e = n.splice(0, 4).map((n => n > o ? "w" : "n")).join("")
              , w = n.splice(n.length - 3, 3).map((n => n > o ? "w" : "n")).join("");
            if ("nnnn" !== e || "wnn" !== w)
                return "";
            for (; n.length > 0; ) {
                const e = n.splice(0, 10)
                  , w = e.filter(( (n, e) => e % 2 == 0)).map((n => n > o ? "w" : "n")).join("");
                t.push(p.indexOf(w));
                const r = e.filter(( (n, e) => e % 2 != 0)).map((n => n > o ? "w" : "n")).join("");
                t.push(p.indexOf(r))
            }
        } else {
            const e = n.splice(0, 6).filter(( (n, e) => e % 2 == 0)).map((n => n > o ? "w" : "n")).join("")
              , w = n.splice(n.length - 5, 5).filter(( (n, e) => e % 2 == 0)).map((n => n > o ? "w" : "n")).join("");
            if ("wwn" !== e || "wnw" !== w)
                return "";
            for (; n.length > 0; ) {
                const e = n.splice(0, 10).filter(( (n, e) => e % 2 == 0)).map((n => n > o ? "w" : "n")).join("");
                t.push(p.indexOf(e))
            }
        }
        return t.join("")
    }
    const g = {
        3211: "0",
        2221: "1",
        2122: "2",
        1411: "3",
        1132: "4",
        1231: "5",
        1114: "6",
        1312: "7",
        1213: "8",
        3112: "9"
    };
    function m(n, e="13") {
        let t = "";
        const o = (n[0] + n[1] + n[2]) / 3;
        n.shift(),
        n.shift(),
        n.shift(),
        n.pop(),
        n.pop(),
        n.pop(),
        "13" === e ? n.splice(24, 5) : n.splice(16, 5);
        for (let e = 0; e < n.length; e += 4) {
            const w = n.slice(e, e + 4)
              , r = [w[0] / o, w[1] / o, w[2] / o, w[3] / o].map((n => 1.5 === n ? 1 : Math.round(n)))
              , c = g[r.join("")] || g[r.reverse().join("")];
            t += c || "?"
        }
        return t
    }
    var b;
    function j(n, e) {
        if ("" === n || "" === e)
            return e;
        const t = n.split("");
        return e.split("").forEach(( (n, e) => {
            t[e] && "?" !== t[e] || n && "?" !== n && (t[e] = n)
        }
        )),
        t.join("")
    }
    function v(n) {
        const e = document.createElement("canvas")
          , t = e.getContext("2d");
        if (!t)
            throw new Error("Cannot create canvas 2d context");
        const o = n.naturalWidth
          , w = n.naturalHeight;
        return e.width = o,
        e.height = w,
        t.drawImage(n, 0, 0),
        t.getImageData(0, 0, o, w)
    }
    !function(n) {
        n["code-128"] = "code-128",
        n["code-2of5"] = "code-2of5",
        n["code-39"] = "code-39",
        n["code-93"] = "code-93",
        n["ean-13"] = "ean-13",
        n["ean-8"] = "ean-8",
        n.codabar = "codabar"
    }(b || (b = {}));
    const E = "object" == typeof process && process.release && "node" === process.release.name;
    function M(n, e, t) {
        const o = []
          , w = n.length / (e * t);
        let r = 0
          , c = 0;
        for (let i = 0; i < e; i += 1) {
            let s = 0
              , a = 0;
            for (let o = 0; o < t; o += 1) {
                const t = (o * e + i) * w;
                s += Math.sqrt((Math.pow(n[t], 2) + Math.pow(n[t + 1], 2) + Math.pow(n[t + 2], 2)) / 3)
            }
            a = s / t >= 127 ? 255 : 0,
            255 === a && 0 === r || (a === c ? r += 1 : (o.push(r),
            c = a,
            r = 1),
            i === e - 1 && 0 === a && o.push(r))
        }
        return o
    }
    let S;
    try {
        process && "test" === process.env.NODE_ENV && (S = !0)
    } catch (n) {
        S = !1
    }
    return function({image: n, barcode: e, barcodeType: w, options: c}) {
        return o(this, void 0, void 0, (function*() {
            let i;
            switch (e) {
            case b.codabar:
                i = r;
                break;
            case b["code-128"]:
                i = l;
                break;
            case b["code-39"]:
                i = d;
                break;
            case b["code-93"]:
                i = u;
                break;
            case b["code-2of5"]:
                i = C;
                break;
            case b["ean-13"]:
                i = m,
                w = "13";
                break;
            case b["ean-8"]:
                i = m,
                w = "8";
                break;
            default:
                throw new Error(`Invalid barcode specified. Available decoders: ${b}.`)
            }
            const s = S || c && c.singlePass || !1
              , {data: a, width: f, height: h} = (p = n).data && p.width && p.height ? n : yield function(n) {
                return o(this, void 0, void 0, (function*() {
                    return new Promise(( (e, o) => {
                        if ("string" == typeof n)
                            if (n.startsWith("#")) {
                                const t = document.getElementById(n.substr(1));
                                if (t instanceof HTMLImageElement && e(v(t)),
                                t instanceof HTMLCanvasElement) {
                                    const n = t.getContext("2d");
                                    if (!n)
                                        throw new Error("Cannot create canvas 2d context");
                                    e(n.getImageData(0, 0, t.width, t.height))
                                }
                                o(new Error("Invalid image source specified!"))
                            } else if (!(w = n).startsWith("#") && /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-/]))?/.test(w)) {
                                const t = new Image;
                                t.onerror = o,
                                t.onload = () => e(v(t)),
                                t.src = n
                            } else
                                E && t.read(n, ( (n, t) => {
                                    if (n)
                                        o(n);
                                    else {
                                        const {data: n, width: o, height: w} = t.bitmap;
                                        e({
                                            data: Uint8ClampedArray.from(n),
                                            width: o,
                                            height: w
                                        })
                                    }
                                }
                                ));
                        else if (n instanceof HTMLImageElement)
                            e(v(n));
                        else if (n instanceof HTMLCanvasElement) {
                            const t = n.getContext("2d");
                            if (!t)
                                throw new Error("Cannot create canvas 2d context");
                            e(t.getImageData(0, 0, n.width, n.height))
                        }
                        var w
                    }
                    ))
                }
                ))
            }(n);
            var p;
            const g = a.length / (f * h);
            let O = "";
            c && c.useAdaptiveThreshold && function(n, e, t) {
                const o = new Array(e * t).fill(0)
                  , w = n.length / (e * t)
                  , r = Math.floor(t)
                  , c = Math.floor(r / 2);
                for (let r = 0; r < e; r += 1) {
                    let c = 0;
                    for (let i = 0; i < t; i += 1) {
                        const t = i * e + r
                          , s = t * w
                          , a = (n[s] + n[s + 1] + n[s + 2]) / 3;
                        n[s] = a,
                        n[s + 1] = a,
                        n[s + 2] = a,
                        c += a,
                        o[t] = 0 === r ? c : o[t - 1] + c
                    }
                }
                for (let r = 0; r < e; r += 1)
                    for (let i = 0; i < t; i += 1) {
                        const s = (i * e + r) * w;
                        let a = r - c
                          , l = r + c
                          , f = i - c
                          , d = i + c;
                        a < 0 && (a = 0),
                        l >= e && (l = e - 1),
                        f < 0 && (f = 0),
                        d >= t && (d = t - 1);
                        const h = (l - a) * (d - f)
                          , u = o[d * e + l] - o[f * e + l] - o[d * e + a] + o[f * e + a];
                        let p = 255;
                        n[s] * h < .85 * u && (p = 0),
                        n[s] = p,
                        n[s + 1] = p,
                        n[s + 2] = p
                    }
            }(a, f, h);
            const N = [5, 6, 4, 7, 3, 8, 2, 9, 1]
              , y = Math.round(h / N.length)
              , A = Math.min(2, h);
            for (let n = 0; n < N.length; n += 1) {
                const e = g * f * Math.floor(y * N[n])
                  , t = e + A * g * f
                  , o = M(a.slice(e, t), f, A);
                if (0 === o.length) {
                    if (s || n === N.length - 1)
                        throw new Error("Failed to detect lines in the image!");
                    continue
                }
                const r = i(o, w);
                if (r) {
                    if (s || !r.includes("?"))
                        return r;
                    if (O = j(O, r),
                    !O.includes("?"))
                        return O
                }
            }
            return O
        }
        ))
    }
}
));
//# sourceMappingURL=javascript-barcode-reader.umd.min.js.map
