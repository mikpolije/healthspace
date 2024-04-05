"use strict";
document.addEventListener("DOMContentLoaded", function () {
    {
        const o = document.querySelector(".app-chat-contacts .sidebar-body"),
            n = [].slice.call(document.querySelectorAll(".chat-contact-list-item:not(.chat-contact-list-item-title)")),
            i = document.querySelector(".chat-history-body"),
            u = document.querySelector(".app-chat-sidebar-left .sidebar-body"),
            d = document.querySelector(".app-chat-sidebar-right .sidebar-body"),
            h = [].slice.call(document.querySelectorAll(".form-check-input[name='chat-user-status']")),
            m = $(".chat-sidebar-left-user-about"),
            p = document.querySelector(".form-send-message"),
            v = document.querySelector(".message-input"),
            b = document.querySelector(".chat-search-input"),
            f = $(".speech-to-text"),
            y = {
                active: "avatar-online",
                offline: "avatar-offline",
                away: "avatar-away",
                busy: "avatar-busy"
            };


        function a() {
            i.scrollTo(0, i.scrollHeight)
        }

        function l(e, a, c, t) {
            e.forEach(e => {
                var t = e.textContent.toLowerCase();
                !c || -1 < t.indexOf(c) ? (e.classList.add("d-flex"), e.classList.remove("d-none"), a++) : e.classList.add("d-none")
            }), 0 == a ? t.classList.remove("d-none") : t.classList.add("d-none")
        }
        o && new PerfectScrollbar(o, {
            wheelPropagation: !1,
            suppressScrollX: !0
        }), i && new PerfectScrollbar(i, {
            wheelPropagation: !1,
            suppressScrollX: !0
        }), u && new PerfectScrollbar(u, {
            wheelPropagation: !1,
            suppressScrollX: !0
        }), d && new PerfectScrollbar(d, {
            wheelPropagation: !1,
            suppressScrollX: !0
        }), a(), h.forEach(e => {
           
        }), b && b.addEventListener("keyup", e => {
            var e = e.currentTarget.value.toLowerCase(),
                t = document.querySelector(".chat-list-item-0"),
                a = document.querySelector(".contact-list-item-0"),
                c = [].slice.call(document.querySelectorAll("#chat-list li:not(.chat-contact-list-item-title)")),
                r = [].slice.call(document.querySelectorAll("#contact-list li:not(.chat-contact-list-item-title)"));
            l(c, 0, e, t), l(r, 0, e, a)
        }), p.addEventListener("submit", e => {
            // e.preventDefault(), v.value && ((e = document.createElement("div")).className = "chat-message-text mt-2", e.innerHTML = '<p class="mb-0 text-break">' + v.value + "</p>", document.querySelector("li:last-child .chat-message-wrapper").appendChild(e), v.value = "", a())
        });
        let e = document.querySelector(".chat-history-header [data-target='#app-chat-contacts']"),
            t = document.querySelector(".app-chat-sidebar-left .close-sidebar");
        var c, r, s;
         f.length && null != (c = c || webkitSpeechRecognition) && (r = new c, s = !1, f.on("click", function () {
            const t = $(this);
            !(r.onspeechstart = function () {
                s = !0
            }) === s && r.start(), r.onerror = function (e) {
                s = !1
            }, r.onresult = function (e) {
                t.closest(".form-send-message").find(".message-input").val(e.results[0][0].transcript)
            }, r.onspeechend = function (e) {
                s = !1, r.stop()
            }
        }))
    }
});


function timeAgo(input) {
    const date = (input instanceof Date) ? input : new Date(input);
    const formatter = new Intl.RelativeTimeFormat('en');
    const ranges = {
      years: 3600 * 24 * 365,
      months: 3600 * 24 * 30,
      weeks: 3600 * 24 * 7,
      days: 3600 * 24,
      hours: 3600,
      minutes: 60,
      seconds: 1
    };
    const secondsElapsed = (date.getTime() - Date.now()) / 1000;
    for (let key in ranges) {
      if (ranges[key] < Math.abs(secondsElapsed)) {
        const delta = secondsElapsed / ranges[key];
        return formatter.format(Math.round(delta), key);
      }
    }
  }