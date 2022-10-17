"use strict";

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

function _possibleConstructorReturn(self, call) { if (call && (_typeof(call) === "object" || typeof call === "function")) { return call; } return _assertThisInitialized(self); }

function _assertThisInitialized(self) { if (self === void 0) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return self; }

function _get(target, property, receiver) { if (typeof Reflect !== "undefined" && Reflect.get) { _get = Reflect.get; } else { _get = function _get(target, property, receiver) { var base = _superPropBase(target, property); if (!base) return; var desc = Object.getOwnPropertyDescriptor(base, property); if (desc.get) { return desc.get.call(receiver); } return desc.value; }; } return _get(target, property, receiver || target); }

function _superPropBase(object, property) { while (!Object.prototype.hasOwnProperty.call(object, property)) { object = _getPrototypeOf(object); if (object === null) break; } return object; }

function _getPrototypeOf(o) { _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) { return o.__proto__ || Object.getPrototypeOf(o); }; return _getPrototypeOf(o); }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function"); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, writable: true, configurable: true } }); if (superClass) _setPrototypeOf(subClass, superClass); }

function isNativeReflectConstruct() { if (typeof Reflect === "undefined" || !Reflect.construct) return false; if (Reflect.construct.sham) return false; if (typeof Proxy === "function") return true; try { Date.prototype.toString.call(Reflect.construct(Date, [], function () {})); return true; } catch (e) { return false; } }

function _construct(Parent, args, Class) { if (isNativeReflectConstruct()) { _construct = Reflect.construct; } else { _construct = function _construct(Parent, args, Class) { var a = [null]; a.push.apply(a, args); var Constructor = Function.bind.apply(Parent, a); var instance = new Constructor(); if (Class) _setPrototypeOf(instance, Class.prototype); return instance; }; } return _construct.apply(null, arguments); }

function _setPrototypeOf(o, p) { _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) { o.__proto__ = p; return o; }; return _setPrototypeOf(o, p); }

function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

!function (e, t) {
  "object" == (typeof exports === "undefined" ? "undefined" : _typeof(exports)) && "undefined" != typeof module ? module.exports = t() : "function" == typeof define && define.amd ? define(t) : (e = e || self).Sweetalert2 = t();
}(void 0, function () {
  "use strict";

  var p = {
    awaitingPromise: new WeakMap(),
    promise: new WeakMap(),
    innerParams: new WeakMap(),
    domCache: new WeakMap()
  };

  var e = function e(_e2) {
    var t = {};

    for (var _n in _e2) {
      t[_e2[_n]] = "swal2-" + _e2[_n];
    }

    return t;
  };

  var m = e(["container", "shown", "height-auto", "iosfix", "popup", "modal", "no-backdrop", "no-transition", "toast", "toast-shown", "show", "hide", "close", "title", "html-container", "actions", "confirm", "deny", "cancel", "default-outline", "footer", "icon", "icon-content", "image", "input", "file", "range", "select", "radio", "checkbox", "label", "textarea", "inputerror", "input-label", "validation-message", "progress-steps", "active-progress-step", "progress-step", "progress-step-line", "loader", "loading", "styled", "top", "top-start", "top-end", "top-left", "top-right", "center", "center-start", "center-end", "center-left", "center-right", "bottom", "bottom-start", "bottom-end", "bottom-left", "bottom-right", "grow-row", "grow-column", "grow-fullscreen", "rtl", "timer-progress-bar", "timer-progress-bar-container", "scrollbar-measure", "icon-success", "icon-warning", "icon-info", "icon-question", "icon-error", "no-war"]),
      o = e(["success", "warning", "info", "question", "error"]),
      q = "SweetAlert2:",
      D = function D(e) {
    return e.charAt(0).toUpperCase() + e.slice(1);
  },
      a = function a(e) {
    console.warn("".concat(q, " ").concat("object" == _typeof(e) ? e.join(" ") : e));
  },
      l = function l(e) {
    console.error("".concat(q, " ").concat(e));
  },
      V = [],
      N = function N(e, t) {
    e = '"'.concat(e, '" is deprecated and will be removed in the next major release. Please use "').concat(t, '" instead.'), V.includes(e) || (V.push(e), a(e));
  },
      F = function F(e) {
    return "function" == typeof e ? e() : e;
  },
      R = function R(e) {
    return e && "function" == typeof e.toPromise;
  },
      u = function u(e) {
    return R(e) ? e.toPromise() : Promise.resolve(e);
  },
      U = function U(e) {
    return e && Promise.resolve(e) === e;
  },
      g = function g() {
    return document.body.querySelector(".".concat(m.container));
  },
      t = function t(e) {
    var t = g();
    return t ? t.querySelector(e) : null;
  },
      n = function n(e) {
    return t(".".concat(e));
  },
      h = function h() {
    return n(m.popup);
  },
      r = function r() {
    return n(m.icon);
  },
      W = function W() {
    return n(m.title);
  },
      z = function z() {
    return n(m["html-container"]);
  },
      K = function K() {
    return n(m.image);
  },
      _ = function _() {
    return n(m["progress-steps"]);
  },
      Y = function Y() {
    return n(m["validation-message"]);
  },
      f = function f() {
    return t(".".concat(m.actions, " .").concat(m.confirm));
  },
      b = function b() {
    return t(".".concat(m.actions, " .").concat(m.deny));
  };

  var v = function v() {
    return t(".".concat(m.loader));
  },
      y = function y() {
    return t(".".concat(m.actions, " .").concat(m.cancel));
  },
      Z = function Z() {
    return n(m.actions);
  },
      $ = function $() {
    return n(m.footer);
  },
      J = function J() {
    return n(m["timer-progress-bar"]);
  },
      X = function X() {
    return n(m.close);
  },
      G = function G() {
    var e = Array.from(h().querySelectorAll('[tabindex]:not([tabindex="-1"]):not([tabindex="0"])')).sort(function (e, t) {
      e = parseInt(e.getAttribute("tabindex")), t = parseInt(t.getAttribute("tabindex"));
      return t < e ? 1 : e < t ? -1 : 0;
    }),
        t = Array.from(h().querySelectorAll('\n  a[href],\n  area[href],\n  input:not([disabled]),\n  select:not([disabled]),\n  textarea:not([disabled]),\n  button:not([disabled]),\n  iframe,\n  object,\n  embed,\n  [tabindex="0"],\n  [contenteditable],\n  audio[controls],\n  video[controls],\n  summary\n')).filter(function (e) {
      return "-1" !== e.getAttribute("tabindex");
    });
    return function (t) {
      var n = [];

      for (var _e3 = 0; _e3 < t.length; _e3++) {
        -1 === n.indexOf(t[_e3]) && n.push(t[_e3]);
      }

      return n;
    }(e.concat(t)).filter(function (e) {
      return x(e);
    });
  },
      Q = function Q() {
    return s(document.body, m.shown) && !s(document.body, m["toast-shown"]) && !s(document.body, m["no-backdrop"]);
  },
      ee = function ee() {
    return h() && s(h(), m.toast);
  };

  function te(e) {
    var t = 1 < arguments.length && void 0 !== arguments[1] && arguments[1];
    var n = J();
    x(n) && (t && (n.style.transition = "none", n.style.width = "100%"), setTimeout(function () {
      n.style.transition = "width ".concat(e / 1e3, "s linear"), n.style.width = "0%";
    }, 10));
  }

  var i = {
    previousBodyPadding: null
  },
      w = function w(t, e) {
    t.textContent = "", e && (e = new DOMParser().parseFromString(e, "text/html"), Array.from(e.querySelector("head").childNodes).forEach(function (e) {
      t.appendChild(e);
    }), Array.from(e.querySelector("body").childNodes).forEach(function (e) {
      e instanceof HTMLVideoElement || e instanceof HTMLAudioElement ? t.appendChild(e.cloneNode(!0)) : t.appendChild(e);
    }));
  },
      s = function s(t, e) {
    if (!e) return !1;
    var n = e.split(/\s+/);

    for (var _e4 = 0; _e4 < n.length; _e4++) {
      if (!t.classList.contains(n[_e4])) return !1;
    }

    return !0;
  },
      ne = function ne(t, n) {
    Array.from(t.classList).forEach(function (e) {
      Object.values(m).includes(e) || Object.values(o).includes(e) || Object.values(n.showClass).includes(e) || t.classList.remove(e);
    });
  },
      C = function C(e, t, n) {
    if (ne(e, t), t.customClass && t.customClass[n]) {
      if ("string" != typeof t.customClass[n] && !t.customClass[n].forEach) return a("Invalid type of customClass.".concat(n, '! Expected string or iterable object, got "').concat(_typeof(t.customClass[n]), '"'));
      A(e, t.customClass[n]);
    }
  },
      oe = function oe(e, t) {
    if (!t) return null;

    switch (t) {
      case "select":
      case "textarea":
      case "file":
        return e.querySelector(".".concat(m.popup, " > .").concat(m[t]));

      case "checkbox":
        return e.querySelector(".".concat(m.popup, " > .").concat(m.checkbox, " input"));

      case "radio":
        return e.querySelector(".".concat(m.popup, " > .").concat(m.radio, " input:checked")) || e.querySelector(".".concat(m.popup, " > .").concat(m.radio, " input:first-child"));

      case "range":
        return e.querySelector(".".concat(m.popup, " > .").concat(m.range, " input"));

      default:
        return e.querySelector(".".concat(m.popup, " > .").concat(m.input));
    }
  },
      ie = function ie(e) {
    var t;
    e.focus(), "file" !== e.type && (t = e.value, e.value = "", e.value = t);
  },
      ae = function ae(e, t, n) {
    e && t && (t = "string" == typeof t ? t.split(/\s+/).filter(Boolean) : t).forEach(function (t) {
      Array.isArray(e) ? e.forEach(function (e) {
        n ? e.classList.add(t) : e.classList.remove(t);
      }) : n ? e.classList.add(t) : e.classList.remove(t);
    });
  },
      A = function A(e, t) {
    ae(e, t, !0);
  },
      k = function k(e, t) {
    ae(e, t, !1);
  },
      d = function d(e, t) {
    var n = Array.from(e.children);

    for (var _e5 = 0; _e5 < n.length; _e5++) {
      var o = n[_e5];
      if (o instanceof HTMLElement && s(o, t)) return o;
    }
  },
      c = function c(e, t, n) {
    (n = n === "".concat(parseInt(n)) ? parseInt(n) : n) || 0 === parseInt(n) ? e.style[t] = "number" == typeof n ? "".concat(n, "px") : n : e.style.removeProperty(t);
  },
      B = function B(e) {
    e.style.display = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : "flex";
  },
      P = function P(e) {
    e.style.display = "none";
  },
      re = function re(e, t, n, o) {
    e = e.querySelector(t);
    e && (e.style[n] = o);
  },
      se = function se(e, t) {
    var n = 2 < arguments.length && void 0 !== arguments[2] ? arguments[2] : "flex";
    t ? B(e, n) : P(e);
  },
      x = function x(e) {
    return !(!e || !(e.offsetWidth || e.offsetHeight || e.getClientRects().length));
  },
      ce = function ce() {
    return !x(f()) && !x(b()) && !x(y());
  },
      le = function le(e) {
    return !!(e.scrollHeight > e.clientHeight);
  },
      ue = function ue(e) {
    var e = window.getComputedStyle(e),
        t = parseFloat(e.getPropertyValue("animation-duration") || "0"),
        e = parseFloat(e.getPropertyValue("transition-duration") || "0");
    return 0 < t || 0 < e;
  },
      de = 100,
      E = {},
      pe = function pe() {
    E.previousActiveElement instanceof HTMLElement ? (E.previousActiveElement.focus(), E.previousActiveElement = null) : document.body && document.body.focus();
  },
      me = function me(o) {
    return new Promise(function (e) {
      if (!o) return e();
      var t = window.scrollX,
          n = window.scrollY;
      E.restoreFocusTimeout = setTimeout(function () {
        pe(), e();
      }, de), window.scrollTo(t, n);
    });
  },
      ge = function ge() {
    return "undefined" == typeof window || "undefined" == typeof document;
  },
      he = '\n <div aria-labelledby="'.concat(m.title, '" aria-describedby="').concat(m["html-container"], '" class="').concat(m.popup, '" tabindex="-1">\n   <button type="button" class="').concat(m.close, '"></button>\n   <ul class="').concat(m["progress-steps"], '"></ul>\n   <div class="').concat(m.icon, '"></div>\n   <img class="').concat(m.image, '" />\n   <h2 class="').concat(m.title, '" id="').concat(m.title, '"></h2>\n   <div class="').concat(m["html-container"], '" id="').concat(m["html-container"], '"></div>\n   <input class="').concat(m.input, '" />\n   <input type="file" class="').concat(m.file, '" />\n   <div class="').concat(m.range, '">\n     <input type="range" />\n     <output></output>\n   </div>\n   <select class="').concat(m.select, '"></select>\n   <div class="').concat(m.radio, '"></div>\n   <label for="').concat(m.checkbox, '" class="').concat(m.checkbox, '">\n     <input type="checkbox" />\n     <span class="').concat(m.label, '"></span>\n   </label>\n   <textarea class="').concat(m.textarea, '"></textarea>\n   <div class="').concat(m["validation-message"], '" id="').concat(m["validation-message"], '"></div>\n   <div class="').concat(m.actions, '">\n     <div class="').concat(m.loader, '"></div>\n     <button type="button" class="').concat(m.confirm, '"></button>\n     <button type="button" class="').concat(m.deny, '"></button>\n     <button type="button" class="').concat(m.cancel, '"></button>\n   </div>\n   <div class="').concat(m.footer, '"></div>\n   <div class="').concat(m["timer-progress-bar-container"], '">\n     <div class="').concat(m["timer-progress-bar"], '"></div>\n   </div>\n </div>\n').replace(/(^|\n)\s*/g, ""),
      fe = function fe() {
    var e = g();
    return !!e && (e.remove(), k([document.documentElement, document.body], [m["no-backdrop"], m["toast-shown"], m["has-column"]]), !0);
  },
      T = function T() {
    E.currentInstance.resetValidationMessage();
  },
      be = function be() {
    var e = h(),
        t = d(e, m.input),
        n = d(e, m.file);
    var o = e.querySelector(".".concat(m.range, " input")),
        i = e.querySelector(".".concat(m.range, " output"));
    var a = d(e, m.select),
        r = e.querySelector(".".concat(m.checkbox, " input")),
        e = d(e, m.textarea);
    t.oninput = T, n.onchange = T, a.onchange = T, r.onchange = T, e.oninput = T, o.oninput = function () {
      T(), i.value = o.value;
    }, o.onchange = function () {
      T(), i.value = o.value;
    };
  },
      ve = function ve(e) {
    return "string" == typeof e ? document.querySelector(e) : e;
  },
      ye = function ye(e) {
    var t = h();
    t.setAttribute("role", e.toast ? "alert" : "dialog"), t.setAttribute("aria-live", e.toast ? "polite" : "assertive"), e.toast || t.setAttribute("aria-modal", "true");
  },
      we = function we(e) {
    "rtl" === window.getComputedStyle(e).direction && A(g(), m.rtl);
  },
      Ce = function Ce(e, t) {
    if (e instanceof HTMLElement) t.appendChild(e);else if ("object" == _typeof(e)) {
      var n = e,
          o = t;
      if (n.jquery) Ae(o, n);else w(o, n.toString());
    } else e && w(t, e);
  },
      Ae = function Ae(t, n) {
    if (t.textContent = "", 0 in n) for (var _e6 = 0; _e6 in n; _e6++) {
      t.appendChild(n[_e6].cloneNode(!0));
    } else t.appendChild(n.cloneNode(!0));
  },
      ke = function () {
    if (!ge()) {
      var e = document.createElement("div"),
          t = {
        WebkitAnimation: "webkitAnimationEnd",
        animation: "animationend"
      };

      for (var _n2 in t) {
        if (Object.prototype.hasOwnProperty.call(t, _n2) && void 0 !== e.style[_n2]) return t[_n2];
      }
    }

    return !1;
  }(),
      Be = function Be(e, t) {
    var n,
        o,
        i,
        a,
        r,
        s = Z(),
        c = v(),
        l = ((t.showConfirmButton || t.showDenyButton || t.showCancelButton ? B : P)(s), C(s, t, "actions"), s = s, n = c, o = t, i = f(), a = b(), r = y(), Pe(i, "confirm", o), Pe(a, "deny", o), Pe(r, "cancel", o), i),
        u = a,
        d = r,
        p = o;
    p.buttonsStyling ? (A([l, u, d], m.styled), p.confirmButtonColor && (l.style.backgroundColor = p.confirmButtonColor, A(l, m["default-outline"])), p.denyButtonColor && (u.style.backgroundColor = p.denyButtonColor, A(u, m["default-outline"])), p.cancelButtonColor && (d.style.backgroundColor = p.cancelButtonColor, A(d, m["default-outline"]))) : k([l, u, d], m.styled), o.reverseButtons && (o.toast ? (s.insertBefore(r, i), s.insertBefore(a, i)) : (s.insertBefore(r, n), s.insertBefore(a, n), s.insertBefore(i, n))), w(c, t.loaderHtml), C(c, t, "loader");
  };

  function Pe(e, t, n) {
    se(e, n["show".concat(D(t), "Button")], "inline-block"), w(e, n["".concat(t, "ButtonText")]), e.setAttribute("aria-label", n["".concat(t, "ButtonAriaLabel")]), e.className = m[t], C(e, n, "".concat(t, "Button")), A(e, n["".concat(t, "ButtonClass")]);
  }

  var xe = function xe(e, t) {
    var n = X();
    w(n, t.closeButtonHtml), C(n, t, "closeButton"), se(n, t.showCloseButton), n.setAttribute("aria-label", t.closeButtonAriaLabel);
  },
      Ee = function Ee(e, t) {
    var n,
        o,
        i = g();
    i && (o = i, "string" == typeof (n = t.backdrop) ? o.style.background = n : n || A([document.documentElement, document.body], m["no-backdrop"]), o = i, (n = t.position) in m ? A(o, m[n]) : (a('The "position" parameter is not valid, defaulting to "center"'), A(o, m.center)), n = i, (o = t.grow) && "string" == typeof o && (o = "grow-".concat(o)) in m && A(n, m[o]), C(i, t, "container"));
  };

  var Te = ["input", "file", "range", "select", "radio", "checkbox", "textarea"],
      Se = function Se(e, r) {
    var s = h();
    e = p.innerParams.get(e);
    var c = !e || r.input !== e.input;

    if (Te.forEach(function (e) {
      var t = d(s, m[e]);
      {
        var n = e,
            o = r.inputAttributes,
            i = oe(h(), n);

        if (i) {
          Le(i);

          for (var _a in o) {
            i.setAttribute(_a, o[_a]);
          }
        }
      }
      t.className = m[e], c && P(t);
    }), r.input) {
      if (c) {
        e = r;

        if (S[e.input]) {
          var t = Me(e.input);

          var _n3 = S[e.input](t, e);

          B(t), setTimeout(function () {
            ie(_n3);
          });
        } else l('Unexpected type of input! Expected "text", "email", "password", "number", "tel", "select", "radio", "checkbox", "textarea", "file" or "url", got "'.concat(e.input, '"'));
      }

      t = r, e = Me(t.input);
      "object" == _typeof(t.customClass) && A(e, t.customClass.input);
    }
  },
      Le = function Le(t) {
    for (var _e7 = 0; _e7 < t.attributes.length; _e7++) {
      var n = t.attributes[_e7].name;
      ["type", "value", "style"].includes(n) || t.removeAttribute(n);
    }
  },
      Oe = function Oe(e, t) {
    e.placeholder && !t.inputPlaceholder || (e.placeholder = t.inputPlaceholder);
  },
      je = function je(e, t, n) {
    var o, i;
    n.inputLabel && (e.id = m.input, o = document.createElement("label"), i = m["input-label"], o.setAttribute("for", e.id), o.className = i, "object" == _typeof(n.customClass) && A(o, n.customClass.inputLabel), o.innerText = n.inputLabel, t.insertAdjacentElement("beforebegin", o));
  },
      Me = function Me(e) {
    return d(h(), m[e] || m.input);
  },
      He = function He(e, t) {
    ["string", "number"].includes(_typeof(t)) ? e.value = "".concat(t) : U(t) || a('Unexpected type of inputValue! Expected "string", "number" or "Promise", got "'.concat(_typeof(t), '"'));
  },
      S = {},
      Ie = (S.text = S.email = S.password = S.number = S.tel = S.url = function (e, t) {
    return He(e, t.inputValue), je(e, e, t), Oe(e, t), e.type = t.input, e;
  }, S.file = function (e, t) {
    return je(e, e, t), Oe(e, t), e;
  }, S.range = function (e, t) {
    var n = e.querySelector("input"),
        o = e.querySelector("output");
    return He(n, t.inputValue), n.type = t.input, He(o, t.inputValue), je(n, e, t), e;
  }, S.select = function (e, t) {
    var n;
    return e.textContent = "", t.inputPlaceholder && (n = document.createElement("option"), w(n, t.inputPlaceholder), n.value = "", n.disabled = !0, n.selected = !0, e.appendChild(n)), je(e, e, t), e;
  }, S.radio = function (e) {
    return e.textContent = "", e;
  }, S.checkbox = function (e, t) {
    var n = oe(h(), "checkbox"),
        e = (n.value = "1", n.id = m.checkbox, n.checked = Boolean(t.inputValue), e.querySelector("span"));
    return w(e, t.inputPlaceholder), n;
  }, S.textarea = function (n, e) {
    He(n, e.inputValue), Oe(n, e), je(n, n, e);
    return setTimeout(function () {
      if ("MutationObserver" in window) {
        var _t2 = parseInt(window.getComputedStyle(h()).width);

        new MutationObserver(function () {
          var e = n.offsetWidth + (e = n, parseInt(window.getComputedStyle(e).marginLeft) + parseInt(window.getComputedStyle(e).marginRight));
          e > _t2 ? h().style.width = "".concat(e, "px") : h().style.width = null;
        }).observe(n, {
          attributes: !0,
          attributeFilter: ["style"]
        });
      }
    }), n;
  }, function (e, t) {
    var n = z();
    C(n, t, "htmlContainer"), t.html ? (Ce(t.html, n), B(n, "block")) : t.text ? (n.textContent = t.text, B(n, "block")) : P(n), Se(e, t);
  }),
      qe = function qe(e, t) {
    var n = $();
    se(n, t.footer), t.footer && Ce(t.footer, n), C(n, t, "footer");
  },
      De = function De(e, t) {
    var e = p.innerParams.get(e),
        n = r();
    e && t.icon === e.icon ? (Ue(n, t), Ve(n, t)) : t.icon || t.iconHtml ? t.icon && -1 === Object.keys(o).indexOf(t.icon) ? (l('Unknown icon! Expected "success", "error", "warning", "info" or "question", got "'.concat(t.icon, '"')), P(n)) : (B(n), Ue(n, t), Ve(n, t), A(n, t.showClass.icon)) : P(n);
  },
      Ve = function Ve(e, t) {
    for (var _n4 in o) {
      t.icon !== _n4 && k(e, o[_n4]);
    }

    A(e, o[t.icon]), We(e, t), Ne(), C(e, t, "icon");
  },
      Ne = function Ne() {
    var e = h(),
        t = window.getComputedStyle(e).getPropertyValue("background-color"),
        n = e.querySelectorAll("[class^=swal2-success-circular-line], .swal2-success-fix");

    for (var _e8 = 0; _e8 < n.length; _e8++) {
      n[_e8].style.backgroundColor = t;
    }
  },
      Fe = '\n  <div class="swal2-success-circular-line-left"></div>\n  <span class="swal2-success-line-tip"></span> <span class="swal2-success-line-long"></span>\n  <div class="swal2-success-ring"></div> <div class="swal2-success-fix"></div>\n  <div class="swal2-success-circular-line-right"></div>\n',
      Re = '\n  <span class="swal2-x-mark">\n    <span class="swal2-x-mark-line-left"></span>\n    <span class="swal2-x-mark-line-right"></span>\n  </span>\n',
      Ue = function Ue(e, t) {
    var n = e.innerHTML,
        o;
    var i;
    t.iconHtml ? o = ze(t.iconHtml) : "success" === t.icon ? (o = Fe, n = n.replace(/ style=".*?"/g, "")) : o = "error" === t.icon ? Re : (i = {
      question: "?",
      warning: "!",
      info: "i"
    }, ze(i[t.icon])), n.trim() !== o.trim() && w(e, o);
  },
      We = function We(e, t) {
    if (t.iconColor) {
      e.style.color = t.iconColor, e.style.borderColor = t.iconColor;

      for (var _i = 0, _arr = [".swal2-success-line-tip", ".swal2-success-line-long", ".swal2-x-mark-line-left", ".swal2-x-mark-line-right"]; _i < _arr.length; _i++) {
        var _n5 = _arr[_i];
        re(e, _n5, "backgroundColor", t.iconColor);
      }

      re(e, ".swal2-success-ring", "borderColor", t.iconColor);
    }
  },
      ze = function ze(e) {
    return '<div class="'.concat(m["icon-content"], '">').concat(e, "</div>");
  },
      Ke = function Ke(e, t) {
    var n = K();
    t.imageUrl ? (B(n, ""), n.setAttribute("src", t.imageUrl), n.setAttribute("alt", t.imageAlt), c(n, "width", t.imageWidth), c(n, "height", t.imageHeight), n.className = m.image, C(n, t, "image")) : P(n);
  },
      _e = function _e(e, t) {
    var n = g(),
        o = h(),
        n = (t.toast ? (c(n, "width", t.width), o.style.width = "100%", o.insertBefore(v(), r())) : c(o, "width", t.width), c(o, "padding", t.padding), t.color && (o.style.color = t.color), t.background && (o.style.background = t.background), P(Y()), o),
        o = t;
    (n.className = "".concat(m.popup, " ").concat(x(n) ? o.showClass.popup : ""), o.toast) ? (A([document.documentElement, document.body], m["toast-shown"]), A(n, m.toast)) : A(n, m.modal);
    C(n, o, "popup"), "string" == typeof o.customClass && A(n, o.customClass);
    o.icon && A(n, m["icon-".concat(o.icon)]);
  },
      Ye = function Ye(e, n) {
    var o = _();

    n.progressSteps && 0 !== n.progressSteps.length ? (B(o), o.textContent = "", n.currentProgressStep >= n.progressSteps.length && a("Invalid currentProgressStep parameter, it should be less than progressSteps.length (currentProgressStep like JS arrays starts from 0)"), n.progressSteps.forEach(function (e, t) {
      var e = function (e) {
        var t = document.createElement("li");
        return A(t, m["progress-step"]), w(t, e), t;
      }(e);

      o.appendChild(e), t === n.currentProgressStep && A(e, m["active-progress-step"]), t !== n.progressSteps.length - 1 && (e = function (e) {
        var t = document.createElement("li");
        if (A(t, m["progress-step-line"]), e.progressStepsDistance) c(t, "width", e.progressStepsDistance);
        return t;
      }(n), o.appendChild(e));
    })) : P(o);
  },
      Ze = function Ze(e, t) {
    var n = W();
    se(n, t.title || t.titleText, "block"), t.title && Ce(t.title, n), t.titleText && (n.innerText = t.titleText), C(n, t, "title");
  },
      $e = function $e(e, t) {
    _e(e, t), Ee(e, t), Ye(e, t), De(e, t), Ke(e, t), Ze(e, t), xe(e, t), Ie(e, t), Be(e, t), qe(e, t), "function" == typeof t.didRender && t.didRender(h());
  };

  function Je() {
    var e,
        t,
        n = p.innerParams.get(this);
    n && (e = p.domCache.get(this), P(e.loader), ee() ? n.icon && B(r()) : (t = (n = e).popup.getElementsByClassName(n.loader.getAttribute("data-button-to-replace"))).length ? B(t[0], "inline-block") : ce() && P(n.actions), k([e.popup, e.actions], m.loading), e.popup.removeAttribute("aria-busy"), e.popup.removeAttribute("data-loading"), e.confirmButton.disabled = !1, e.denyButton.disabled = !1, e.cancelButton.disabled = !1);
  }

  var Xe = function Xe() {
    return f() && f().click();
  };

  var L = Object.freeze({
    cancel: "cancel",
    backdrop: "backdrop",
    close: "close",
    esc: "esc",
    timer: "timer"
  }),
      Ge = function Ge(e) {
    e.keydownTarget && e.keydownHandlerAdded && (e.keydownTarget.removeEventListener("keydown", e.keydownHandler, {
      capture: e.keydownListenerCapture
    }), e.keydownHandlerAdded = !1);
  },
      Qe = function Qe(e, t, n) {
    var o = G();
    if (o.length) return (t += n) === o.length ? t = 0 : -1 === t && (t = o.length - 1), o[t].focus();
    h().focus();
  },
      et = ["ArrowRight", "ArrowDown"],
      tt = ["ArrowLeft", "ArrowUp"],
      nt = function nt(e, n, t) {
    var o = p.innerParams.get(e);
    if (o && !n.isComposing && 229 !== n.keyCode) if (o.stopKeydownPropagation && n.stopPropagation(), "Enter" === n.key) e = e, s = n, i = o, F(i.allowEnterKey) && s.target && e.getInput() && s.target instanceof HTMLElement && s.target.outerHTML === e.getInput().outerHTML && (["textarea", "file"].includes(i.input) || (Xe(), s.preventDefault()));else if ("Tab" === n.key) {
      e = n;
      var i = o;
      var a = e.target,
          r = G();

      var _t3 = -1;

      for (var _e9 = 0; _e9 < r.length; _e9++) {
        if (a === r[_e9]) {
          _t3 = _e9;
          break;
        }
      }

      e.shiftKey ? Qe(i, _t3, -1) : Qe(i, _t3, 1);
      e.stopPropagation(), e.preventDefault();
    } else if ([].concat(et, tt).includes(n.key)) {
      var s = n.key,
          e = f(),
          c = b(),
          l = y();

      if (!(document.activeElement instanceof HTMLElement) || [e, c, l].includes(document.activeElement)) {
        var u = et.includes(s) ? "nextElementSibling" : "previousElementSibling";
        var _t4 = document.activeElement;

        for (var _e10 = 0; _e10 < Z().children.length; _e10++) {
          if (!(_t4 = _t4[u])) return;
          if (_t4 instanceof HTMLButtonElement && x(_t4)) break;
        }

        _t4 instanceof HTMLButtonElement && _t4.focus();
      }
    } else if ("Escape" === n.key) {
      e = n, c = o, l = t;

      if (F(c.allowEscapeKey)) {
        e.preventDefault();
        l(L.esc);
      }
    }
  };

  var ot = {
    swalPromiseResolve: new WeakMap(),
    swalPromiseReject: new WeakMap()
  };

  var it = function it() {
    Array.from(document.body.children).forEach(function (e) {
      e === g() || e.contains(g()) || (e.hasAttribute("aria-hidden") && e.setAttribute("data-previous-aria-hidden", e.getAttribute("aria-hidden")), e.setAttribute("aria-hidden", "true"));
    });
  },
      at = function at() {
    Array.from(document.body.children).forEach(function (e) {
      e.hasAttribute("data-previous-aria-hidden") ? (e.setAttribute("aria-hidden", e.getAttribute("data-previous-aria-hidden")), e.removeAttribute("data-previous-aria-hidden")) : e.removeAttribute("aria-hidden");
    });
  },
      rt = function rt() {
    if ((/iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream || "MacIntel" === navigator.platform && 1 < navigator.maxTouchPoints) && !s(document.body, m.iosfix)) {
      var e = document.body.scrollTop;
      document.body.style.top = "".concat(-1 * e, "px"), A(document.body, m.iosfix);
      {
        e = g();

        var _t5;

        e.ontouchstart = function (e) {
          _t5 = st(e);
        }, e.ontouchmove = function (e) {
          _t5 && (e.preventDefault(), e.stopPropagation());
        };
      }
      var e = navigator.userAgent,
          t = !!e.match(/iPad/i) || !!e.match(/iPhone/i),
          n = !!e.match(/WebKit/i);
      t && n && !e.match(/CriOS/i) && h().scrollHeight > window.innerHeight - 44 && (g().style.paddingBottom = "".concat(44, "px"));
    }
  },
      st = function st(e) {
    var t,
        n = e.target,
        o = g();
    return !((t = e).touches && t.touches.length && "stylus" === t.touches[0].touchType || (t = e).touches && 1 < t.touches.length) && (n === o || !le(o) && n instanceof HTMLElement && "INPUT" !== n.tagName && !("TEXTAREA" === n.tagName || le(z()) && z().contains(n)));
  },
      ct = function ct() {
    var e;
    s(document.body, m.iosfix) && (e = parseInt(document.body.style.top, 10), k(document.body, m.iosfix), document.body.style.top = "", document.body.scrollTop = -1 * e);
  },
      lt = function lt() {
    var e, t;
    null === i.previousBodyPadding && document.body.scrollHeight > window.innerHeight && (i.previousBodyPadding = parseInt(window.getComputedStyle(document.body).getPropertyValue("padding-right")), document.body.style.paddingRight = "".concat(i.previousBodyPadding + ((e = document.createElement("div")).className = m["scrollbar-measure"], document.body.appendChild(e), t = e.getBoundingClientRect().width - e.clientWidth, document.body.removeChild(e), t), "px"));
  },
      ut = function ut() {
    null !== i.previousBodyPadding && (document.body.style.paddingRight = "".concat(i.previousBodyPadding, "px"), i.previousBodyPadding = null);
  };

  function dt(e, t, n, o) {
    ee() ? ht(e, o) : (me(n).then(function () {
      return ht(e, o);
    }), Ge(E)), /^((?!chrome|android).)*safari/i.test(navigator.userAgent) ? (t.setAttribute("style", "display:none !important"), t.removeAttribute("class"), t.innerHTML = "") : t.remove(), Q() && (ut(), ct(), at()), k([document.documentElement, document.body], [m.shown, m["height-auto"], m["no-backdrop"], m["toast-shown"]]);
  }

  function pt(e) {
    e = void 0 !== (t = e) ? Object.assign({
      isConfirmed: !1,
      isDenied: !1,
      isDismissed: !1
    }, t) : {
      isConfirmed: !1,
      isDenied: !1,
      isDismissed: !0
    };

    var t = ot.swalPromiseResolve.get(this),
        n = function (e) {
      var t = h();
      if (!t) return false;
      var n = p.innerParams.get(e);
      if (!n || s(t, n.hideClass.popup)) return false;
      k(t, n.showClass.popup), A(t, n.hideClass.popup);
      var o = g();
      return k(o, n.showClass.backdrop), A(o, n.hideClass.backdrop), gt(e, t, n), true;
    }(this);

    this.isAwaitingPromise() ? e.isDismissed || (mt(this), t(e)) : n && t(e);
  }

  var mt = function mt(e) {
    e.isAwaitingPromise() && (p.awaitingPromise["delete"](e), p.innerParams.get(e) || e._destroy());
  },
      gt = function gt(e, t, n) {
    var o,
        i,
        a,
        r = g(),
        s = ke && ue(t);
    "function" == typeof n.willClose && n.willClose(t), s ? (s = e, o = t, t = r, i = n.returnFocus, a = n.didClose, E.swalCloseEventFinishedCallback = dt.bind(null, s, t, i, a), o.addEventListener(ke, function (e) {
      e.target === o && (E.swalCloseEventFinishedCallback(), delete E.swalCloseEventFinishedCallback);
    })) : dt(e, r, n.returnFocus, n.didClose);
  },
      ht = function ht(e, t) {
    setTimeout(function () {
      "function" == typeof t && t.bind(e.params)(), e._destroy();
    });
  };

  function ft(e, t, n) {
    var o = p.domCache.get(e);
    t.forEach(function (e) {
      o[e].disabled = n;
    });
  }

  function bt(e, t) {
    if (e) if ("radio" === e.type) {
      var n = e.parentNode.parentNode.querySelectorAll("input");

      for (var _e11 = 0; _e11 < n.length; _e11++) {
        n[_e11].disabled = t;
      }
    } else e.disabled = t;
  }

  var O = {
    title: "",
    titleText: "",
    text: "",
    html: "",
    footer: "",
    icon: void 0,
    iconColor: void 0,
    iconHtml: void 0,
    template: void 0,
    toast: !1,
    showClass: {
      popup: "swal2-show",
      backdrop: "swal2-backdrop-show",
      icon: "swal2-icon-show"
    },
    hideClass: {
      popup: "swal2-hide",
      backdrop: "swal2-backdrop-hide",
      icon: "swal2-icon-hide"
    },
    customClass: {},
    target: "body",
    color: void 0,
    backdrop: !0,
    heightAuto: !0,
    allowOutsideClick: !0,
    allowEscapeKey: !0,
    allowEnterKey: !0,
    stopKeydownPropagation: !0,
    keydownListenerCapture: !1,
    showConfirmButton: !0,
    showDenyButton: !1,
    showCancelButton: !1,
    preConfirm: void 0,
    preDeny: void 0,
    confirmButtonText: "OK",
    confirmButtonAriaLabel: "",
    confirmButtonColor: void 0,
    denyButtonText: "No",
    denyButtonAriaLabel: "",
    denyButtonColor: void 0,
    cancelButtonText: "Cancel",
    cancelButtonAriaLabel: "",
    cancelButtonColor: void 0,
    buttonsStyling: !0,
    reverseButtons: !1,
    focusConfirm: !0,
    focusDeny: !1,
    focusCancel: !1,
    returnFocus: !0,
    showCloseButton: !1,
    closeButtonHtml: "&times;",
    closeButtonAriaLabel: "Close this dialog",
    loaderHtml: "",
    showLoaderOnConfirm: !1,
    showLoaderOnDeny: !1,
    imageUrl: void 0,
    imageWidth: void 0,
    imageHeight: void 0,
    imageAlt: "",
    timer: void 0,
    timerProgressBar: !1,
    width: void 0,
    padding: void 0,
    background: void 0,
    input: void 0,
    inputPlaceholder: "",
    inputLabel: "",
    inputValue: "",
    inputOptions: {},
    inputAutoTrim: !0,
    inputAttributes: {},
    inputValidator: void 0,
    returnInputValueOnDeny: !1,
    validationMessage: void 0,
    grow: !1,
    position: "center",
    progressSteps: [],
    currentProgressStep: void 0,
    progressStepsDistance: void 0,
    willOpen: void 0,
    didOpen: void 0,
    didRender: void 0,
    willClose: void 0,
    didClose: void 0,
    didDestroy: void 0,
    scrollbarPadding: !0
  },
      vt = ["allowEscapeKey", "allowOutsideClick", "background", "buttonsStyling", "cancelButtonAriaLabel", "cancelButtonColor", "cancelButtonText", "closeButtonAriaLabel", "closeButtonHtml", "color", "confirmButtonAriaLabel", "confirmButtonColor", "confirmButtonText", "currentProgressStep", "customClass", "denyButtonAriaLabel", "denyButtonColor", "denyButtonText", "didClose", "didDestroy", "footer", "hideClass", "html", "icon", "iconColor", "iconHtml", "imageAlt", "imageHeight", "imageUrl", "imageWidth", "preConfirm", "preDeny", "progressSteps", "returnFocus", "reverseButtons", "showCancelButton", "showCloseButton", "showConfirmButton", "showDenyButton", "text", "title", "titleText", "willClose"],
      yt = {},
      wt = ["allowOutsideClick", "allowEnterKey", "backdrop", "focusConfirm", "focusDeny", "focusCancel", "returnFocus", "heightAuto", "keydownListenerCapture"],
      Ct = function Ct(e) {
    return Object.prototype.hasOwnProperty.call(O, e);
  },
      At = function At(e) {
    return -1 !== vt.indexOf(e);
  },
      kt = function kt(e) {
    return yt[e];
  },
      Bt = function Bt(e) {
    !e.backdrop && e.allowOutsideClick && a('"allowOutsideClick" parameter requires `backdrop` parameter to be set to `true`');

    for (var _n6 in e) {
      t = _n6, Ct(t) || a('Unknown parameter "'.concat(t, '"')), e.toast && (t = _n6, wt.includes(t) && a('The parameter "'.concat(t, '" is incompatible with toasts'))), t = _n6, kt(t) && N(t, kt(t));
    }

    var t;
  };

  var Pt = function Pt(e) {
    e.isAwaitingPromise() ? (xt(p, e), p.awaitingPromise.set(e, !0)) : (xt(ot, e), xt(p, e));
  },
      xt = function xt(e, t) {
    for (var _n7 in e) {
      e[_n7]["delete"](t);
    }
  };

  e = Object.freeze({
    hideLoading: Je,
    disableLoading: Je,
    getInput: function getInput(e) {
      var t = p.innerParams.get(e || this);
      return (e = p.domCache.get(e || this)) ? oe(e.popup, t.input) : null;
    },
    close: pt,
    isAwaitingPromise: function isAwaitingPromise() {
      return !!p.awaitingPromise.get(this);
    },
    rejectPromise: function rejectPromise(e) {
      var t = ot.swalPromiseReject.get(this);
      mt(this), t && t(e);
    },
    handleAwaitingPromise: mt,
    closePopup: pt,
    closeModal: pt,
    closeToast: pt,
    enableButtons: function enableButtons() {
      ft(this, ["confirmButton", "denyButton", "cancelButton"], !1);
    },
    disableButtons: function disableButtons() {
      ft(this, ["confirmButton", "denyButton", "cancelButton"], !0);
    },
    enableInput: function enableInput() {
      bt(this.getInput(), !1);
    },
    disableInput: function disableInput() {
      bt(this.getInput(), !0);
    },
    showValidationMessage: function showValidationMessage(e) {
      var t = p.domCache.get(this),
          n = p.innerParams.get(this);
      w(t.validationMessage, e), t.validationMessage.className = m["validation-message"], n.customClass && n.customClass.validationMessage && A(t.validationMessage, n.customClass.validationMessage), B(t.validationMessage), (e = this.getInput()) && (e.setAttribute("aria-invalid", !0), e.setAttribute("aria-describedby", m["validation-message"]), ie(e), A(e, m.inputerror));
    },
    resetValidationMessage: function resetValidationMessage() {
      var e = p.domCache.get(this);
      e.validationMessage && P(e.validationMessage), (e = this.getInput()) && (e.removeAttribute("aria-invalid"), e.removeAttribute("aria-describedby"), k(e, m.inputerror));
    },
    getProgressSteps: function getProgressSteps() {
      return p.domCache.get(this).progressSteps;
    },
    update: function update(e) {
      var t = h(),
          n = p.innerParams.get(this);
      if (!t || s(t, n.hideClass.popup)) return a("You're trying to update the closed or closing popup, that won't work. Use the update() method in preConfirm parameter or show a new popup.");
      t = function (t) {
        var n = {};
        return Object.keys(t).forEach(function (e) {
          if (At(e)) n[e] = t[e];else a("Invalid parameter to update: ".concat(e));
        }), n;
      }(e), n = Object.assign({}, n, t), $e(this, n), p.innerParams.set(this, n), Object.defineProperties(this, {
        params: {
          value: Object.assign({}, this.params, e),
          writable: !1,
          enumerable: !0
        }
      });
    },
    _destroy: function _destroy() {
      var e = p.domCache.get(this),
          t = p.innerParams.get(this);
      t ? (e.popup && E.swalCloseEventFinishedCallback && (E.swalCloseEventFinishedCallback(), delete E.swalCloseEventFinishedCallback), "function" == typeof t.didDestroy && t.didDestroy(), e = this, Pt(e), delete e.params, delete E.keydownHandler, delete E.keydownTarget, delete E.currentInstance) : Pt(this);
    }
  });

  var j = function j(e) {
    var t,
        n,
        o,
        i = h(),
        a = (i || new Cn(), i = h(), v());
    ee() ? P(r()) : (t = i, e = e, n = Z(), o = v(), !e && x(f()) && (e = f()), B(n), e && (P(e), o.setAttribute("data-button-to-replace", e.className)), o.parentNode.insertBefore(o, e), A([t, n], m.loading)), B(a), i.setAttribute("data-loading", "true"), i.setAttribute("aria-busy", "true"), i.focus();
  },
      Et = function Et(t, n) {
    var o = h(),
        i = function i(e) {
      St[n.input](o, Lt(e), n);
    };

    R(n.inputOptions) || U(n.inputOptions) ? (j(f()), u(n.inputOptions).then(function (e) {
      t.hideLoading(), i(e);
    })) : "object" == _typeof(n.inputOptions) ? i(n.inputOptions) : l("Unexpected type of inputOptions! Expected object, Map or Promise, got ".concat(_typeof(n.inputOptions)));
  },
      Tt = function Tt(t, n) {
    var o = t.getInput();
    P(o), u(n.inputValue).then(function (e) {
      o.value = "number" === n.input ? "".concat(parseFloat(e) || 0) : "".concat(e), B(o), o.focus(), t.hideLoading();
    })["catch"](function (e) {
      l("Error in inputValue promise: ".concat(e)), o.value = "", B(o), o.focus(), t.hideLoading();
    });
  },
      St = {
    select: function select(e, t, i) {
      var o = d(e, m.select),
          a = function a(e, t, n) {
        var o = document.createElement("option");
        o.value = n, w(o, t), o.selected = Ot(n, i.inputValue), e.appendChild(o);
      };

      t.forEach(function (e) {
        var t = e[0],
            e = e[1];

        if (Array.isArray(e)) {
          var _n8 = document.createElement("optgroup");

          _n8.label = t, _n8.disabled = !1, o.appendChild(_n8), e.forEach(function (e) {
            return a(_n8, e[1], e[0]);
          });
        } else a(o, e, t);
      }), o.focus();
    },
    radio: function radio(e, t, i) {
      var a = d(e, m.radio);
      t.forEach(function (e) {
        var t = e[0],
            e = e[1],
            n = document.createElement("input"),
            o = document.createElement("label"),
            t = (n.type = "radio", n.name = m.radio, n.value = t, Ot(t, i.inputValue) && (n.checked = !0), document.createElement("span"));
        w(t, e), t.className = m.label, o.appendChild(n), o.appendChild(t), a.appendChild(o);
      });
      e = a.querySelectorAll("input");
      e.length && e[0].focus();
    }
  },
      Lt = function Lt(n) {
    var o = [];
    return "undefined" != typeof Map && n instanceof Map ? n.forEach(function (e, t) {
      var n = e;
      "object" == _typeof(n) && (n = Lt(n)), o.push([t, n]);
    }) : Object.keys(n).forEach(function (e) {
      var t = n[e];
      "object" == _typeof(t) && (t = Lt(t)), o.push([e, t]);
    }), o;
  },
      Ot = function Ot(e, t) {
    return t && t.toString() === e.toString();
  },
      jt = function jt(e, t) {
    var n = p.innerParams.get(e);

    if (n.input) {
      var o = function (e, t) {
        var n,
            o = e.getInput();
        if (!o) return null;

        switch (t.input) {
          case "checkbox":
            return o.checked ? 1 : 0;

          case "radio":
            return (n = o).checked ? n.value : null;

          case "file":
            return (n = o).files.length ? null !== n.getAttribute("multiple") ? n.files : n.files[0] : null;

          default:
            return t.inputAutoTrim ? o.value.trim() : o.value;
        }
      }(e, n);

      if (n.inputValidator) {
        var i = e;
        var a = o;
        var r = t;

        var _s = p.innerParams.get(i),
            _c = (i.disableInput(), Promise.resolve().then(function () {
          return u(_s.inputValidator(a, _s.validationMessage));
        }));

        _c.then(function (e) {
          i.enableButtons(), i.enableInput(), e ? i.showValidationMessage(e) : ("deny" === r ? Mt : qt)(i, a);
        });
      } else e.getInput().checkValidity() ? ("deny" === t ? Mt : qt)(e, o) : (e.enableButtons(), e.showValidationMessage(n.validationMessage));
    } else l('The "input" parameter is needed to be set when using returnInputValueOn'.concat(D(t)));
  },
      Mt = function Mt(t, n) {
    var e = p.innerParams.get(t || void 0);
    e.showLoaderOnDeny && j(b()), e.preDeny ? (p.awaitingPromise.set(t || void 0, !0), Promise.resolve().then(function () {
      return u(e.preDeny(n, e.validationMessage));
    }).then(function (e) {
      !1 === e ? (t.hideLoading(), mt(t)) : t.close({
        isDenied: !0,
        value: void 0 === e ? n : e
      });
    })["catch"](function (e) {
      return It(t || void 0, e);
    })) : t.close({
      isDenied: !0,
      value: n
    });
  },
      Ht = function Ht(e, t) {
    e.close({
      isConfirmed: !0,
      value: t
    });
  },
      It = function It(e, t) {
    e.rejectPromise(t);
  },
      qt = function qt(t, n) {
    var e = p.innerParams.get(t || void 0);
    e.showLoaderOnConfirm && j(), e.preConfirm ? (t.resetValidationMessage(), p.awaitingPromise.set(t || void 0, !0), Promise.resolve().then(function () {
      return u(e.preConfirm(n, e.validationMessage));
    }).then(function (e) {
      x(Y()) || !1 === e ? (t.hideLoading(), mt(t)) : Ht(t, void 0 === e ? n : e);
    })["catch"](function (e) {
      return It(t || void 0, e);
    })) : Ht(t, n);
  },
      Dt = function Dt(n, e, o) {
    e.popup.onclick = function () {
      var e,
          t = p.innerParams.get(n);
      t && ((e = t).showConfirmButton || e.showDenyButton || e.showCancelButton || e.showCloseButton || t.timer || t.input) || o(L.close);
    };
  };

  var Vt = !1;

  var Nt = function Nt(t) {
    t.popup.onmousedown = function () {
      t.container.onmouseup = function (e) {
        t.container.onmouseup = void 0, e.target === t.container && (Vt = !0);
      };
    };
  },
      Ft = function Ft(t) {
    t.container.onmousedown = function () {
      t.popup.onmouseup = function (e) {
        t.popup.onmouseup = void 0, e.target !== t.popup && !t.popup.contains(e.target) || (Vt = !0);
      };
    };
  },
      Rt = function Rt(n, o, i) {
    o.container.onclick = function (e) {
      var t = p.innerParams.get(n);
      Vt ? Vt = !1 : e.target === o.container && F(t.allowOutsideClick) && i(L.backdrop);
    };
  },
      Ut = function Ut(e) {
    return "object" == _typeof(e) && e.jquery;
  },
      Wt = function Wt(e) {
    return e instanceof Element || Ut(e);
  };

  var zt = function zt() {
    if (E.timeout) return e = J(), t = parseInt(window.getComputedStyle(e).width), e.style.removeProperty("transition"), e.style.width = "100%", n = parseInt(window.getComputedStyle(e).width), t = t / n * 100, e.style.removeProperty("transition"), e.style.width = "".concat(t, "%"), E.timeout.stop();
    var e, t, n;
  },
      Kt = function Kt() {
    var e;
    if (E.timeout) return e = E.timeout.start(), te(e), e;
  };

  var _t = !1;

  var Yt = {};

  var Zt = function Zt(t) {
    for (var _e12 = t.target; _e12 && _e12 !== document; _e12 = _e12.parentNode) {
      for (var _o in Yt) {
        var n = _e12.getAttribute(_o);

        if (n) return void Yt[_o].fire({
          template: n
        });
      }
    }
  };

  var $t = Object.freeze({
    isValidParameter: Ct,
    isUpdatableParameter: At,
    isDeprecatedParameter: kt,
    argsToParams: function argsToParams(n) {
      var o = {};
      return "object" != _typeof(n[0]) || Wt(n[0]) ? ["title", "html", "icon"].forEach(function (e, t) {
        t = n[t];
        "string" == typeof t || Wt(t) ? o[e] = t : void 0 !== t && l("Unexpected type of ".concat(e, '! Expected "string" or "Element", got ').concat(_typeof(t)));
      }) : Object.assign(o, n[0]), o;
    },
    isVisible: function isVisible() {
      return x(h());
    },
    clickConfirm: Xe,
    clickDeny: function clickDeny() {
      return b() && b().click();
    },
    clickCancel: function clickCancel() {
      return y() && y().click();
    },
    getContainer: g,
    getPopup: h,
    getTitle: W,
    getHtmlContainer: z,
    getImage: K,
    getIcon: r,
    getInputLabel: function getInputLabel() {
      return n(m["input-label"]);
    },
    getCloseButton: X,
    getActions: Z,
    getConfirmButton: f,
    getDenyButton: b,
    getCancelButton: y,
    getLoader: v,
    getFooter: $,
    getTimerProgressBar: J,
    getFocusableElements: G,
    getValidationMessage: Y,
    isLoading: function isLoading() {
      return h().hasAttribute("data-loading");
    },
    fire: function fire() {
      for (var e = arguments.length, t = new Array(e), n = 0; n < e; n++) {
        t[n] = arguments[n];
      }

      return _construct(this, t);
    },
    mixin: function mixin(n) {
      var e =
      /*#__PURE__*/
      function (_this) {
        _inherits(e, _this);

        function e() {
          _classCallCheck(this, e);

          return _possibleConstructorReturn(this, _getPrototypeOf(e).apply(this, arguments));
        }

        _createClass(e, [{
          key: "_main",
          value: function _main(e, t) {
            return _get(_getPrototypeOf(e.prototype), "_main", this).call(this, e, Object.assign({}, n, t));
          }
        }]);

        return e;
      }(this);

      return e;
    },
    showLoading: j,
    enableLoading: j,
    getTimerLeft: function getTimerLeft() {
      return E.timeout && E.timeout.getTimerLeft();
    },
    stopTimer: zt,
    resumeTimer: Kt,
    toggleTimer: function toggleTimer() {
      var e = E.timeout;
      return e && (e.running ? zt : Kt)();
    },
    increaseTimer: function increaseTimer(e) {
      if (E.timeout) return e = E.timeout.increase(e), te(e, !0), e;
    },
    isTimerRunning: function isTimerRunning() {
      return E.timeout && E.timeout.isRunning();
    },
    bindClickHandler: function bindClickHandler() {
      var e = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : "data-swal-template";
      Yt[e] = this, _t || (document.body.addEventListener("click", Zt), _t = !0);
    }
  });

  var Jt =
  /*#__PURE__*/
  function () {
    function Jt(e, t) {
      _classCallCheck(this, Jt);

      this.callback = e, this.remaining = t, this.running = !1, this.start();
    }

    _createClass(Jt, [{
      key: "start",
      value: function start() {
        return this.running || (this.running = !0, this.started = new Date(), this.id = setTimeout(this.callback, this.remaining)), this.remaining;
      }
    }, {
      key: "stop",
      value: function stop() {
        return this.running && (this.running = !1, clearTimeout(this.id), this.remaining -= new Date().getTime() - this.started.getTime()), this.remaining;
      }
    }, {
      key: "increase",
      value: function increase(e) {
        var t = this.running;
        return t && this.stop(), this.remaining += e, t && this.start(), this.remaining;
      }
    }, {
      key: "getTimerLeft",
      value: function getTimerLeft() {
        return this.running && (this.stop(), this.start()), this.remaining;
      }
    }, {
      key: "isRunning",
      value: function isRunning() {
        return this.running;
      }
    }]);

    return Jt;
  }();

  var Xt = ["swal-title", "swal-html", "swal-footer"],
      Gt = function Gt(e) {
    var n = {};
    return Array.from(e.querySelectorAll("swal-param")).forEach(function (e) {
      M(e, ["name", "value"]);
      var t = e.getAttribute("name"),
          e = e.getAttribute("value");
      "boolean" == typeof O[t] ? n[t] = "false" !== e : "object" == _typeof(O[t]) ? n[t] = JSON.parse(e) : n[t] = e;
    }), n;
  },
      Qt = function Qt(e) {
    var n = {};
    return Array.from(e.querySelectorAll("swal-function-param")).forEach(function (e) {
      var t = e.getAttribute("name"),
          e = e.getAttribute("value");
      n[t] = new Function("return ".concat(e))();
    }), n;
  },
      en = function en(e) {
    var n = {};
    return Array.from(e.querySelectorAll("swal-button")).forEach(function (e) {
      M(e, ["type", "color", "aria-label"]);
      var t = e.getAttribute("type");
      n["".concat(t, "ButtonText")] = e.innerHTML, n["show".concat(D(t), "Button")] = !0, e.hasAttribute("color") && (n["".concat(t, "ButtonColor")] = e.getAttribute("color")), e.hasAttribute("aria-label") && (n["".concat(t, "ButtonAriaLabel")] = e.getAttribute("aria-label"));
    }), n;
  },
      tn = function tn(e) {
    var t = {},
        e = e.querySelector("swal-image");
    return e && (M(e, ["src", "width", "height", "alt"]), e.hasAttribute("src") && (t.imageUrl = e.getAttribute("src")), e.hasAttribute("width") && (t.imageWidth = e.getAttribute("width")), e.hasAttribute("height") && (t.imageHeight = e.getAttribute("height")), e.hasAttribute("alt") && (t.imageAlt = e.getAttribute("alt"))), t;
  },
      nn = function nn(e) {
    var t = {},
        e = e.querySelector("swal-icon");
    return e && (M(e, ["type", "color"]), e.hasAttribute("type") && (t.icon = e.getAttribute("type")), e.hasAttribute("color") && (t.iconColor = e.getAttribute("color")), t.iconHtml = e.innerHTML), t;
  },
      on = function on(e) {
    var n = {};
    var t = e.querySelector("swal-input"),
        t = (t && (M(t, ["type", "label", "placeholder", "value"]), n.input = t.getAttribute("type") || "text", t.hasAttribute("label") && (n.inputLabel = t.getAttribute("label")), t.hasAttribute("placeholder") && (n.inputPlaceholder = t.getAttribute("placeholder")), t.hasAttribute("value") && (n.inputValue = t.getAttribute("value"))), Array.from(e.querySelectorAll("swal-input-option")));
    return t.length && (n.inputOptions = {}, t.forEach(function (e) {
      M(e, ["value"]);
      var t = e.getAttribute("value"),
          e = e.innerHTML;
      n.inputOptions[t] = e;
    })), n;
  },
      an = function an(e, t) {
    var n = {};

    for (var _a2 in t) {
      var o = t[_a2],
          i = e.querySelector(o);
      i && (M(i, []), n[o.replace(/^swal-/, "")] = i.innerHTML.trim());
    }

    return n;
  },
      rn = function rn(e) {
    var t = Xt.concat(["swal-param", "swal-function-param", "swal-button", "swal-image", "swal-icon", "swal-input", "swal-input-option"]);
    Array.from(e.children).forEach(function (e) {
      e = e.tagName.toLowerCase();
      t.includes(e) || a("Unrecognized element <".concat(e, ">"));
    });
  },
      M = function M(t, n) {
    Array.from(t.attributes).forEach(function (e) {
      -1 === n.indexOf(e.name) && a(['Unrecognized attribute "'.concat(e.name, '" on <').concat(t.tagName.toLowerCase(), ">."), "".concat(n.length ? "Allowed attributes are: ".concat(n.join(", ")) : "To set the value, use HTML within the element.")]);
    });
  },
      sn = 10,
      cn = function cn(e) {
    var t = h();
    e.target === t && (e = g(), t.removeEventListener(ke, cn), e.style.overflowY = "auto");
  },
      ln = function ln(e, t) {
    ke && ue(t) ? (e.style.overflowY = "hidden", t.addEventListener(ke, cn)) : e.style.overflowY = "auto";
  },
      un = function un(e, t, n) {
    rt(), t && "hidden" !== n && lt(), setTimeout(function () {
      e.scrollTop = 0;
    });
  },
      dn = function dn(e, t, n) {
    A(e, n.showClass.backdrop), t.style.setProperty("opacity", "0", "important"), B(t, "grid"), setTimeout(function () {
      A(t, n.showClass.popup), t.style.removeProperty("opacity");
    }, sn), A([document.documentElement, document.body], m.shown), n.heightAuto && n.backdrop && !n.toast && A([document.documentElement, document.body], m["height-auto"]);
  };

  var pn = {
    email: function email(e, t) {
      return /^[a-zA-Z0-9.+_-]+@[a-zA-Z0-9.-]+\.[a-zA-Z0-9-]{2,24}$/.test(e) ? Promise.resolve() : Promise.resolve(t || "Invalid email address");
    },
    url: function url(e, t) {
      return /^https?:\/\/(www\.)?[-a-zA-Z0-9@:%._+~#=]{1,256}\.[a-z]{2,63}\b([-a-zA-Z0-9@:%_+.~#?&/=]*)$/.test(e) ? Promise.resolve() : Promise.resolve(t || "Invalid URL");
    }
  };

  function mn(e) {
    var t, n, o;
    (t = e).inputValidator || Object.keys(pn).forEach(function (e) {
      t.input === e && (t.inputValidator = pn[e]);
    }), e.showLoaderOnConfirm && !e.preConfirm && a("showLoaderOnConfirm is set to true, but preConfirm is not defined.\nshowLoaderOnConfirm should be used together with preConfirm, see usage example:\nhttps://sweetalert2.github.io/#ajax-request"), (n = e).target && ("string" != typeof n.target || document.querySelector(n.target)) && ("string" == typeof n.target || n.target.appendChild) || (a('Target parameter is not valid, defaulting to "body"'), n.target = "body"), "string" == typeof e.title && (e.title = e.title.split("\n").join("<br />")), n = e, e = fe(), ge() ? l("SweetAlert2 requires document to initialize") : ((o = document.createElement("div")).className = m.container, e && A(o, m["no-transition"]), w(o, he), (e = ve(n.target)).appendChild(o), ye(n), we(e), be());
  }

  var H;

  var I =
  /*#__PURE__*/
  function () {
    function I() {
      _classCallCheck(this, I);

      if ("undefined" != typeof window) {
        H = this;

        for (var e = arguments.length, t = new Array(e), n = 0; n < e; n++) {
          t[n] = arguments[n];
        }

        var o = Object.freeze(this.constructor.argsToParams(t)),
            o = (Object.defineProperties(this, {
          params: {
            value: o,
            writable: !1,
            enumerable: !0,
            configurable: !0
          }
        }), H._main(H.params));
        p.promise.set(this, o);
      }
    }

    _createClass(I, [{
      key: "_main",
      value: function _main(e) {
        var t = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : {},
            e = (Bt(Object.assign({}, t, e)), E.currentInstance && (E.currentInstance._destroy(), Q() && at()), E.currentInstance = H, hn(e, t)),
            t = (mn(e), Object.freeze(e), E.timeout && (E.timeout.stop(), delete E.timeout), clearTimeout(E.restoreFocusTimeout), fn(H));
        return $e(H, e), p.innerParams.set(H, e), gn(H, t, e);
      }
    }, {
      key: "then",
      value: function then(e) {
        return p.promise.get(this).then(e);
      }
    }, {
      key: "finally",
      value: function _finally(e) {
        return p.promise.get(this)["finally"](e);
      }
    }]);

    return I;
  }();

  var gn = function gn(l, u, d) {
    return new Promise(function (e, t) {
      var n = function n(e) {
        l.close({
          isDismissed: !0,
          dismiss: e
        });
      };

      var o, i, a;
      ot.swalPromiseResolve.set(l, e), ot.swalPromiseReject.set(l, t), u.confirmButton.onclick = function () {
        var e, t;
        e = l, t = p.innerParams.get(e), e.disableButtons(), t.input ? jt(e, "confirm") : qt(e, !0);
      }, u.denyButton.onclick = function () {
        var e, t;
        e = l, t = p.innerParams.get(e), e.disableButtons(), t.returnInputValueOnDeny ? jt(e, "deny") : Mt(e, !1);
      }, u.cancelButton.onclick = function () {
        var e, t;
        e = l, t = n, e.disableButtons(), t(L.cancel);
      }, u.closeButton.onclick = function () {
        n(L.close);
      }, e = l, t = u, a = n, (p.innerParams.get(e).toast ? Dt : (Nt(t), Ft(t), Rt))(e, t, a), o = l, e = E, t = d, i = n, Ge(e), t.toast || (e.keydownHandler = function (e) {
        return nt(o, e, i);
      }, e.keydownTarget = t.keydownListenerCapture ? window : h(), e.keydownListenerCapture = t.keydownListenerCapture, e.keydownTarget.addEventListener("keydown", e.keydownHandler, {
        capture: e.keydownListenerCapture
      }), e.keydownHandlerAdded = !0), a = l, "select" === (t = d).input || "radio" === t.input ? Et(a, t) : ["text", "email", "number", "tel", "textarea"].includes(t.input) && (R(t.inputValue) || U(t.inputValue)) && (j(f()), Tt(a, t));
      {
        var r = d;

        var _s2 = g(),
            _c2 = h();

        "function" == typeof r.willOpen && r.willOpen(_c2), e = window.getComputedStyle(document.body).overflowY, dn(_s2, _c2, r), setTimeout(function () {
          ln(_s2, _c2);
        }, sn), Q() && (un(_s2, r.scrollbarPadding, e), it()), ee() || E.previousActiveElement || (E.previousActiveElement = document.activeElement), "function" == typeof r.didOpen && setTimeout(function () {
          return r.didOpen(_c2);
        }), k(_s2, m["no-transition"]);
      }
      bn(E, d, n), vn(u, d), setTimeout(function () {
        u.container.scrollTop = 0;
      });
    });
  },
      hn = function hn(e, t) {
    var n = (n = "string" == typeof (n = e).template ? document.querySelector(n.template) : n.template) ? (n = n.content, rn(n), Object.assign(Gt(n), Qt(n), en(n), tn(n), nn(n), on(n), an(n, Xt))) : {},
        t = Object.assign({}, O, t, n, e);
    return t.showClass = Object.assign({}, O.showClass, t.showClass), t.hideClass = Object.assign({}, O.hideClass, t.hideClass), t;
  },
      fn = function fn(e) {
    var t = {
      popup: h(),
      container: g(),
      actions: Z(),
      confirmButton: f(),
      denyButton: b(),
      cancelButton: y(),
      loader: v(),
      closeButton: X(),
      validationMessage: Y(),
      progressSteps: _()
    };
    return p.domCache.set(e, t), t;
  },
      bn = function bn(e, t, n) {
    var o = J();
    P(o), t.timer && (e.timeout = new Jt(function () {
      n("timer"), delete e.timeout;
    }, t.timer), t.timerProgressBar && (B(o), C(o, t, "timerProgressBar"), setTimeout(function () {
      e.timeout && e.timeout.running && te(t.timer);
    })));
  },
      vn = function vn(e, t) {
    t.toast || (F(t.allowEnterKey) ? yn(e, t) || Qe(t, -1, 1) : wn());
  },
      yn = function yn(e, t) {
    return t.focusDeny && x(e.denyButton) ? (e.denyButton.focus(), !0) : t.focusCancel && x(e.cancelButton) ? (e.cancelButton.focus(), !0) : !(!t.focusConfirm || !x(e.confirmButton)) && (e.confirmButton.focus(), !0);
  },
      wn = function wn() {
    document.activeElement instanceof HTMLElement && "function" == typeof document.activeElement.blur && document.activeElement.blur();
  },
      Cn = ("undefined" != typeof window && /^ru\b/.test(navigator.language) && location.host.match(/\.(ru|su|xn--p1ai)$/) && (document.body.style.pointerEvents = "none"), Object.assign(I.prototype, e), Object.assign(I, $t), Object.keys(e).forEach(function (e) {
    I[e] = function () {
      var _H;

      if (H) return (_H = H)[e].apply(_H, arguments);
    };
  }), I.DismissReason = L, I.version = "11.5.0", I);

  return Cn["default"] = Cn;
}), void 0 !== void 0 && (void 0).Sweetalert2 && ((void 0).swal = (void 0).sweetAlert = (void 0).Swal = (void 0).SweetAlert = (void 0).Sweetalert2);
"undefined" != typeof document && function (e, t) {
  var n = e.createElement("style");
  if (e.getElementsByTagName("head")[0].appendChild(n), n.styleSheet) n.styleSheet.disabled || (n.styleSheet.cssText = t);else try {
    n.innerHTML = t;
  } catch (e) {
    n.innerText = t;
  }
}(document, ".swal2-popup.swal2-toast{box-sizing:border-box;grid-column:1/4!important;grid-row:1/4!important;grid-template-columns:1fr 99fr 1fr;padding:1em;overflow-y:hidden;background:#fff;box-shadow:0 0 1px hsla(0deg,0%,0%,.075),0 1px 2px hsla(0deg,0%,0%,.075),1px 2px 4px hsla(0deg,0%,0%,.075),1px 3px 8px hsla(0deg,0%,0%,.075),2px 4px 16px hsla(0deg,0%,0%,.075);pointer-events:all}.swal2-popup.swal2-toast>*{grid-column:2}.swal2-popup.swal2-toast .swal2-title{margin:.5em 1em;padding:0;font-size:1em;text-align:initial}.swal2-popup.swal2-toast .swal2-loading{justify-content:center}.swal2-popup.swal2-toast .swal2-input{height:2em;margin:.5em;font-size:1em}.swal2-popup.swal2-toast .swal2-validation-message{font-size:1em}.swal2-popup.swal2-toast .swal2-footer{margin:.5em 0 0;padding:.5em 0 0;font-size:.8em}.swal2-popup.swal2-toast .swal2-close{grid-column:3/3;grid-row:1/99;align-self:center;width:.8em;height:.8em;margin:0;font-size:2em}.swal2-popup.swal2-toast .swal2-html-container{margin:.5em 1em;padding:0;overflow:initial;font-size:1em;text-align:initial}.swal2-popup.swal2-toast .swal2-html-container:empty{padding:0}.swal2-popup.swal2-toast .swal2-loader{grid-column:1;grid-row:1/99;align-self:center;width:2em;height:2em;margin:.25em}.swal2-popup.swal2-toast .swal2-icon{grid-column:1;grid-row:1/99;align-self:center;width:2em;min-width:2em;height:2em;margin:0 .5em 0 0}.swal2-popup.swal2-toast .swal2-icon .swal2-icon-content{display:flex;align-items:center;font-size:1.8em;font-weight:700}.swal2-popup.swal2-toast .swal2-icon.swal2-success .swal2-success-ring{width:2em;height:2em}.swal2-popup.swal2-toast .swal2-icon.swal2-error [class^=swal2-x-mark-line]{top:.875em;width:1.375em}.swal2-popup.swal2-toast .swal2-icon.swal2-error [class^=swal2-x-mark-line][class$=left]{left:.3125em}.swal2-popup.swal2-toast .swal2-icon.swal2-error [class^=swal2-x-mark-line][class$=right]{right:.3125em}.swal2-popup.swal2-toast .swal2-actions{justify-content:flex-start;height:auto;margin:0;margin-top:.5em;padding:0 .5em}.swal2-popup.swal2-toast .swal2-styled{margin:.25em .5em;padding:.4em .6em;font-size:1em}.swal2-popup.swal2-toast .swal2-success{border-color:#a5dc86}.swal2-popup.swal2-toast .swal2-success [class^=swal2-success-circular-line]{position:absolute;width:1.6em;height:3em;transform:rotate(45deg);border-radius:50%}.swal2-popup.swal2-toast .swal2-success [class^=swal2-success-circular-line][class$=left]{top:-.8em;left:-.5em;transform:rotate(-45deg);transform-origin:2em 2em;border-radius:4em 0 0 4em}.swal2-popup.swal2-toast .swal2-success [class^=swal2-success-circular-line][class$=right]{top:-.25em;left:.9375em;transform-origin:0 1.5em;border-radius:0 4em 4em 0}.swal2-popup.swal2-toast .swal2-success .swal2-success-ring{width:2em;height:2em}.swal2-popup.swal2-toast .swal2-success .swal2-success-fix{top:0;left:.4375em;width:.4375em;height:2.6875em}.swal2-popup.swal2-toast .swal2-success [class^=swal2-success-line]{height:.3125em}.swal2-popup.swal2-toast .swal2-success [class^=swal2-success-line][class$=tip]{top:1.125em;left:.1875em;width:.75em}.swal2-popup.swal2-toast .swal2-success [class^=swal2-success-line][class$=long]{top:.9375em;right:.1875em;width:1.375em}.swal2-popup.swal2-toast .swal2-success.swal2-icon-show .swal2-success-line-tip{animation:swal2-toast-animate-success-line-tip .75s}.swal2-popup.swal2-toast .swal2-success.swal2-icon-show .swal2-success-line-long{animation:swal2-toast-animate-success-line-long .75s}.swal2-popup.swal2-toast.swal2-show{animation:swal2-toast-show .5s}.swal2-popup.swal2-toast.swal2-hide{animation:swal2-toast-hide .1s forwards}.swal2-container{display:grid;position:fixed;z-index:1060;top:0;right:0;bottom:0;left:0;box-sizing:border-box;grid-template-areas:\"top-start     top            top-end\" \"center-start  center         center-end\" \"bottom-start  bottom-center  bottom-end\";grid-template-rows:minmax(min-content,auto) minmax(min-content,auto) minmax(min-content,auto);height:100%;padding:.625em;overflow-x:hidden;transition:background-color .1s;-webkit-overflow-scrolling:touch}.swal2-container.swal2-backdrop-show,.swal2-container.swal2-noanimation{background:rgba(0,0,0,.4)}.swal2-container.swal2-backdrop-hide{background:0 0!important}.swal2-container.swal2-bottom-start,.swal2-container.swal2-center-start,.swal2-container.swal2-top-start{grid-template-columns:minmax(0,1fr) auto auto}.swal2-container.swal2-bottom,.swal2-container.swal2-center,.swal2-container.swal2-top{grid-template-columns:auto minmax(0,1fr) auto}.swal2-container.swal2-bottom-end,.swal2-container.swal2-center-end,.swal2-container.swal2-top-end{grid-template-columns:auto auto minmax(0,1fr)}.swal2-container.swal2-top-start>.swal2-popup{align-self:start}.swal2-container.swal2-top>.swal2-popup{grid-column:2;align-self:start;justify-self:center}.swal2-container.swal2-top-end>.swal2-popup,.swal2-container.swal2-top-right>.swal2-popup{grid-column:3;align-self:start;justify-self:end}.swal2-container.swal2-center-left>.swal2-popup,.swal2-container.swal2-center-start>.swal2-popup{grid-row:2;align-self:center}.swal2-container.swal2-center>.swal2-popup{grid-column:2;grid-row:2;align-self:center;justify-self:center}.swal2-container.swal2-center-end>.swal2-popup,.swal2-container.swal2-center-right>.swal2-popup{grid-column:3;grid-row:2;align-self:center;justify-self:end}.swal2-container.swal2-bottom-left>.swal2-popup,.swal2-container.swal2-bottom-start>.swal2-popup{grid-column:1;grid-row:3;align-self:end}.swal2-container.swal2-bottom>.swal2-popup{grid-column:2;grid-row:3;justify-self:center;align-self:end}.swal2-container.swal2-bottom-end>.swal2-popup,.swal2-container.swal2-bottom-right>.swal2-popup{grid-column:3;grid-row:3;align-self:end;justify-self:end}.swal2-container.swal2-grow-fullscreen>.swal2-popup,.swal2-container.swal2-grow-row>.swal2-popup{grid-column:1/4;width:100%}.swal2-container.swal2-grow-column>.swal2-popup,.swal2-container.swal2-grow-fullscreen>.swal2-popup{grid-row:1/4;align-self:stretch}.swal2-container.swal2-no-transition{transition:none!important}.swal2-popup{display:none;position:relative;box-sizing:border-box;grid-template-columns:minmax(0,100%);width:32em;max-width:100%;padding:0 0 1.25em;border:none;border-radius:5px;background:#fff;color:#545454;font-family:inherit;font-size:1rem}.swal2-popup:focus{outline:0}.swal2-popup.swal2-loading{overflow-y:hidden}.swal2-title{position:relative;max-width:100%;margin:0;padding:.8em 1em 0;color:inherit;font-size:1.875em;font-weight:600;text-align:center;text-transform:none;word-wrap:break-word}.swal2-actions{display:flex;z-index:1;box-sizing:border-box;flex-wrap:wrap;align-items:center;justify-content:center;width:auto;margin:1.25em auto 0;padding:0}.swal2-actions:not(.swal2-loading) .swal2-styled[disabled]{opacity:.4}.swal2-actions:not(.swal2-loading) .swal2-styled:hover{background-image:linear-gradient(rgba(0,0,0,.1),rgba(0,0,0,.1))}.swal2-actions:not(.swal2-loading) .swal2-styled:active{background-image:linear-gradient(rgba(0,0,0,.2),rgba(0,0,0,.2))}.swal2-loader{display:none;align-items:center;justify-content:center;width:2.2em;height:2.2em;margin:0 1.875em;animation:swal2-rotate-loading 1.5s linear 0s infinite normal;border-width:.25em;border-style:solid;border-radius:100%;border-color:#2778c4 transparent #2778c4 transparent}.swal2-styled{margin:.3125em;padding:.625em 1.1em;transition:box-shadow .1s;box-shadow:0 0 0 3px transparent;font-weight:500}.swal2-styled:not([disabled]){cursor:pointer}.swal2-styled.swal2-confirm{border:0;border-radius:.25em;background:initial;background-color:#7066e0;color:#fff;font-size:1em}.swal2-styled.swal2-confirm:focus{box-shadow:0 0 0 3px rgba(112,102,224,.5)}.swal2-styled.swal2-deny{border:0;border-radius:.25em;background:initial;background-color:#dc3741;color:#fff;font-size:1em}.swal2-styled.swal2-deny:focus{box-shadow:0 0 0 3px rgba(220,55,65,.5)}.swal2-styled.swal2-cancel{border:0;border-radius:.25em;background:initial;background-color:#6e7881;color:#fff;font-size:1em}.swal2-styled.swal2-cancel:focus{box-shadow:0 0 0 3px rgba(110,120,129,.5)}.swal2-styled.swal2-default-outline:focus{box-shadow:0 0 0 3px rgba(100,150,200,.5)}.swal2-styled:focus{outline:0}.swal2-styled::-moz-focus-inner{border:0}.swal2-footer{justify-content:center;margin:1em 0 0;padding:1em 1em 0;border-top:1px solid #eee;color:inherit;font-size:1em}.swal2-timer-progress-bar-container{position:absolute;right:0;bottom:0;left:0;grid-column:auto!important;overflow:hidden;border-bottom-right-radius:5px;border-bottom-left-radius:5px}.swal2-timer-progress-bar{width:100%;height:.25em;background:rgba(0,0,0,.2)}.swal2-image{max-width:100%;margin:2em auto 1em}.swal2-close{z-index:2;align-items:center;justify-content:center;width:1.2em;height:1.2em;margin-top:0;margin-right:0;margin-bottom:-1.2em;padding:0;overflow:hidden;transition:color .1s,box-shadow .1s;border:none;border-radius:5px;background:0 0;color:#ccc;font-family:serif;font-family:monospace;font-size:2.5em;cursor:pointer;justify-self:end}.swal2-close:hover{transform:none;background:0 0;color:#f27474}.swal2-close:focus{outline:0;box-shadow:inset 0 0 0 3px rgba(100,150,200,.5)}.swal2-close::-moz-focus-inner{border:0}.swal2-html-container{z-index:1;justify-content:center;margin:1em 1.6em .3em;padding:0;overflow:auto;color:inherit;font-size:1.125em;font-weight:400;line-height:normal;text-align:center;word-wrap:break-word;word-break:break-word}.swal2-checkbox,.swal2-file,.swal2-input,.swal2-radio,.swal2-select,.swal2-textarea{margin:1em 2em 3px}.swal2-file,.swal2-input,.swal2-textarea{box-sizing:border-box;width:auto;transition:border-color .1s,box-shadow .1s;border:1px solid #d9d9d9;border-radius:.1875em;background:0 0;box-shadow:inset 0 1px 1px rgba(0,0,0,.06),0 0 0 3px transparent;color:inherit;font-size:1.125em}.swal2-file.swal2-inputerror,.swal2-input.swal2-inputerror,.swal2-textarea.swal2-inputerror{border-color:#f27474!important;box-shadow:0 0 2px #f27474!important}.swal2-file:focus,.swal2-input:focus,.swal2-textarea:focus{border:1px solid #b4dbed;outline:0;box-shadow:inset 0 1px 1px rgba(0,0,0,.06),0 0 0 3px rgba(100,150,200,.5)}.swal2-file::-moz-placeholder,.swal2-input::-moz-placeholder,.swal2-textarea::-moz-placeholder{color:#ccc}.swal2-file::placeholder,.swal2-input::placeholder,.swal2-textarea::placeholder{color:#ccc}.swal2-range{margin:1em 2em 3px;background:#fff}.swal2-range input{width:80%}.swal2-range output{width:20%;color:inherit;font-weight:600;text-align:center}.swal2-range input,.swal2-range output{height:2.625em;padding:0;font-size:1.125em;line-height:2.625em}.swal2-input{height:2.625em;padding:0 .75em}.swal2-file{width:75%;margin-right:auto;margin-left:auto;background:0 0;font-size:1.125em}.swal2-textarea{height:6.75em;padding:.75em}.swal2-select{min-width:50%;max-width:100%;padding:.375em .625em;background:0 0;color:inherit;font-size:1.125em}.swal2-checkbox,.swal2-radio{align-items:center;justify-content:center;background:#fff;color:inherit}.swal2-checkbox label,.swal2-radio label{margin:0 .6em;font-size:1.125em}.swal2-checkbox input,.swal2-radio input{flex-shrink:0;margin:0 .4em}.swal2-input-label{display:flex;justify-content:center;margin:1em auto 0}.swal2-validation-message{align-items:center;justify-content:center;margin:1em 0 0;padding:.625em;overflow:hidden;background:#f0f0f0;color:#666;font-size:1em;font-weight:300}.swal2-validation-message::before{content:\"!\";display:inline-block;width:1.5em;min-width:1.5em;height:1.5em;margin:0 .625em;border-radius:50%;background-color:#f27474;color:#fff;font-weight:600;line-height:1.5em;text-align:center}.swal2-icon{position:relative;box-sizing:content-box;justify-content:center;width:5em;height:5em;margin:2.5em auto .6em;border:.25em solid transparent;border-radius:50%;border-color:#000;font-family:inherit;line-height:5em;cursor:default;-webkit-user-select:none;-moz-user-select:none;user-select:none}.swal2-icon .swal2-icon-content{display:flex;align-items:center;font-size:3.75em}.swal2-icon.swal2-error{border-color:#f27474;color:#f27474}.swal2-icon.swal2-error .swal2-x-mark{position:relative;flex-grow:1}.swal2-icon.swal2-error [class^=swal2-x-mark-line]{display:block;position:absolute;top:2.3125em;width:2.9375em;height:.3125em;border-radius:.125em;background-color:#f27474}.swal2-icon.swal2-error [class^=swal2-x-mark-line][class$=left]{left:1.0625em;transform:rotate(45deg)}.swal2-icon.swal2-error [class^=swal2-x-mark-line][class$=right]{right:1em;transform:rotate(-45deg)}.swal2-icon.swal2-error.swal2-icon-show{animation:swal2-animate-error-icon .5s}.swal2-icon.swal2-error.swal2-icon-show .swal2-x-mark{animation:swal2-animate-error-x-mark .5s}.swal2-icon.swal2-warning{border-color:#facea8;color:#f8bb86}.swal2-icon.swal2-warning.swal2-icon-show{animation:swal2-animate-error-icon .5s}.swal2-icon.swal2-warning.swal2-icon-show .swal2-icon-content{animation:swal2-animate-i-mark .5s}.swal2-icon.swal2-info{border-color:#9de0f6;color:#3fc3ee}.swal2-icon.swal2-info.swal2-icon-show{animation:swal2-animate-error-icon .5s}.swal2-icon.swal2-info.swal2-icon-show .swal2-icon-content{animation:swal2-animate-i-mark .8s}.swal2-icon.swal2-question{border-color:#c9dae1;color:#87adbd}.swal2-icon.swal2-question.swal2-icon-show{animation:swal2-animate-error-icon .5s}.swal2-icon.swal2-question.swal2-icon-show .swal2-icon-content{animation:swal2-animate-question-mark .8s}.swal2-icon.swal2-success{border-color:#a5dc86;color:#a5dc86}.swal2-icon.swal2-success [class^=swal2-success-circular-line]{position:absolute;width:3.75em;height:7.5em;transform:rotate(45deg);border-radius:50%}.swal2-icon.swal2-success [class^=swal2-success-circular-line][class$=left]{top:-.4375em;left:-2.0635em;transform:rotate(-45deg);transform-origin:3.75em 3.75em;border-radius:7.5em 0 0 7.5em}.swal2-icon.swal2-success [class^=swal2-success-circular-line][class$=right]{top:-.6875em;left:1.875em;transform:rotate(-45deg);transform-origin:0 3.75em;border-radius:0 7.5em 7.5em 0}.swal2-icon.swal2-success .swal2-success-ring{position:absolute;z-index:2;top:-.25em;left:-.25em;box-sizing:content-box;width:100%;height:100%;border:.25em solid rgba(165,220,134,.3);border-radius:50%}.swal2-icon.swal2-success .swal2-success-fix{position:absolute;z-index:1;top:.5em;left:1.625em;width:.4375em;height:5.625em;transform:rotate(-45deg)}.swal2-icon.swal2-success [class^=swal2-success-line]{display:block;position:absolute;z-index:2;height:.3125em;border-radius:.125em;background-color:#a5dc86}.swal2-icon.swal2-success [class^=swal2-success-line][class$=tip]{top:2.875em;left:.8125em;width:1.5625em;transform:rotate(45deg)}.swal2-icon.swal2-success [class^=swal2-success-line][class$=long]{top:2.375em;right:.5em;width:2.9375em;transform:rotate(-45deg)}.swal2-icon.swal2-success.swal2-icon-show .swal2-success-line-tip{animation:swal2-animate-success-line-tip .75s}.swal2-icon.swal2-success.swal2-icon-show .swal2-success-line-long{animation:swal2-animate-success-line-long .75s}.swal2-icon.swal2-success.swal2-icon-show .swal2-success-circular-line-right{animation:swal2-rotate-success-circular-line 4.25s ease-in}.swal2-progress-steps{flex-wrap:wrap;align-items:center;max-width:100%;margin:1.25em auto;padding:0;background:0 0;font-weight:600}.swal2-progress-steps li{display:inline-block;position:relative}.swal2-progress-steps .swal2-progress-step{z-index:20;flex-shrink:0;width:2em;height:2em;border-radius:2em;background:#2778c4;color:#fff;line-height:2em;text-align:center}.swal2-progress-steps .swal2-progress-step.swal2-active-progress-step{background:#2778c4}.swal2-progress-steps .swal2-progress-step.swal2-active-progress-step~.swal2-progress-step{background:#add8e6;color:#fff}.swal2-progress-steps .swal2-progress-step.swal2-active-progress-step~.swal2-progress-step-line{background:#add8e6}.swal2-progress-steps .swal2-progress-step-line{z-index:10;flex-shrink:0;width:2.5em;height:.4em;margin:0 -1px;background:#2778c4}[class^=swal2]{-webkit-tap-highlight-color:transparent}.swal2-show{animation:swal2-show .3s}.swal2-hide{animation:swal2-hide .15s forwards}.swal2-noanimation{transition:none}.swal2-scrollbar-measure{position:absolute;top:-9999px;width:50px;height:50px;overflow:scroll}.swal2-rtl .swal2-close{margin-right:initial;margin-left:0}.swal2-rtl .swal2-timer-progress-bar{right:0;left:auto}@keyframes swal2-toast-show{0%{transform:translateY(-.625em) rotateZ(2deg)}33%{transform:translateY(0) rotateZ(-2deg)}66%{transform:translateY(.3125em) rotateZ(2deg)}100%{transform:translateY(0) rotateZ(0)}}@keyframes swal2-toast-hide{100%{transform:rotateZ(1deg);opacity:0}}@keyframes swal2-toast-animate-success-line-tip{0%{top:.5625em;left:.0625em;width:0}54%{top:.125em;left:.125em;width:0}70%{top:.625em;left:-.25em;width:1.625em}84%{top:1.0625em;left:.75em;width:.5em}100%{top:1.125em;left:.1875em;width:.75em}}@keyframes swal2-toast-animate-success-line-long{0%{top:1.625em;right:1.375em;width:0}65%{top:1.25em;right:.9375em;width:0}84%{top:.9375em;right:0;width:1.125em}100%{top:.9375em;right:.1875em;width:1.375em}}@keyframes swal2-show{0%{transform:scale(.7)}45%{transform:scale(1.05)}80%{transform:scale(.95)}100%{transform:scale(1)}}@keyframes swal2-hide{0%{transform:scale(1);opacity:1}100%{transform:scale(.5);opacity:0}}@keyframes swal2-animate-success-line-tip{0%{top:1.1875em;left:.0625em;width:0}54%{top:1.0625em;left:.125em;width:0}70%{top:2.1875em;left:-.375em;width:3.125em}84%{top:3em;left:1.3125em;width:1.0625em}100%{top:2.8125em;left:.8125em;width:1.5625em}}@keyframes swal2-animate-success-line-long{0%{top:3.375em;right:2.875em;width:0}65%{top:3.375em;right:2.875em;width:0}84%{top:2.1875em;right:0;width:3.4375em}100%{top:2.375em;right:.5em;width:2.9375em}}@keyframes swal2-rotate-success-circular-line{0%{transform:rotate(-45deg)}5%{transform:rotate(-45deg)}12%{transform:rotate(-405deg)}100%{transform:rotate(-405deg)}}@keyframes swal2-animate-error-x-mark{0%{margin-top:1.625em;transform:scale(.4);opacity:0}50%{margin-top:1.625em;transform:scale(.4);opacity:0}80%{margin-top:-.375em;transform:scale(1.15)}100%{margin-top:0;transform:scale(1);opacity:1}}@keyframes swal2-animate-error-icon{0%{transform:rotateX(100deg);opacity:0}100%{transform:rotateX(0);opacity:1}}@keyframes swal2-rotate-loading{0%{transform:rotate(0)}100%{transform:rotate(360deg)}}@keyframes swal2-animate-question-mark{0%{transform:rotateY(-360deg)}100%{transform:rotateY(0)}}@keyframes swal2-animate-i-mark{0%{transform:rotateZ(45deg);opacity:0}25%{transform:rotateZ(-25deg);opacity:.4}50%{transform:rotateZ(15deg);opacity:.8}75%{transform:rotateZ(-5deg);opacity:1}100%{transform:rotateX(0);opacity:1}}body.swal2-shown:not(.swal2-no-backdrop):not(.swal2-toast-shown){overflow:hidden}body.swal2-height-auto{height:auto!important}body.swal2-no-backdrop .swal2-container{background-color:transparent!important;pointer-events:none}body.swal2-no-backdrop .swal2-container .swal2-popup{pointer-events:all}body.swal2-no-backdrop .swal2-container .swal2-modal{box-shadow:0 0 10px rgba(0,0,0,.4)}@media print{body.swal2-shown:not(.swal2-no-backdrop):not(.swal2-toast-shown){overflow-y:scroll!important}body.swal2-shown:not(.swal2-no-backdrop):not(.swal2-toast-shown)>[aria-hidden=true]{display:none}body.swal2-shown:not(.swal2-no-backdrop):not(.swal2-toast-shown) .swal2-container{position:static!important}}body.swal2-toast-shown .swal2-container{box-sizing:border-box;width:360px;max-width:100%;background-color:transparent;pointer-events:none}body.swal2-toast-shown .swal2-container.swal2-top{top:0;right:auto;bottom:auto;left:50%;transform:translateX(-50%)}body.swal2-toast-shown .swal2-container.swal2-top-end,body.swal2-toast-shown .swal2-container.swal2-top-right{top:0;right:0;bottom:auto;left:auto}body.swal2-toast-shown .swal2-container.swal2-top-left,body.swal2-toast-shown .swal2-container.swal2-top-start{top:0;right:auto;bottom:auto;left:0}body.swal2-toast-shown .swal2-container.swal2-center-left,body.swal2-toast-shown .swal2-container.swal2-center-start{top:50%;right:auto;bottom:auto;left:0;transform:translateY(-50%)}body.swal2-toast-shown .swal2-container.swal2-center{top:50%;right:auto;bottom:auto;left:50%;transform:translate(-50%,-50%)}body.swal2-toast-shown .swal2-container.swal2-center-end,body.swal2-toast-shown .swal2-container.swal2-center-right{top:50%;right:0;bottom:auto;left:auto;transform:translateY(-50%)}body.swal2-toast-shown .swal2-container.swal2-bottom-left,body.swal2-toast-shown .swal2-container.swal2-bottom-start{top:auto;right:auto;bottom:0;left:0}body.swal2-toast-shown .swal2-container.swal2-bottom{top:auto;right:auto;bottom:0;left:50%;transform:translateX(-50%)}body.swal2-toast-shown .swal2-container.swal2-bottom-end,body.swal2-toast-shown .swal2-container.swal2-bottom-right{top:auto;right:0;bottom:0;left:auto}");