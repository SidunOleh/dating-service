Fancybox.bind("[data-fancybox]", {});

//__________________________Header__________________________//

$(".burger-menu").click(function () {
    $(".header-menu").toggleClass("open");
    $("#header").toggleClass("open");
    $("html").addClass("lock");
});

$(".header-menu .close").click(function () {
    $(".header-menu").removeClass("open");
    $("#header").toggleClass("open");
    $("html").removeClass("lock");
});
if ($("header .advertising-banner").length) {
    var headerHeight = $(".advertising-banner").outerHeight();
    $(".header-menu").css("height", `calc(100vh - ${headerHeight}px)`);
    $(".authPopup").css("top", `${headerHeight}px`);
}
$(".closePage").on("click", function () {
    window.close();
});

$(document).ready(function () {
    if (!localStorage.getItem("isAdult")) {
        $("#isAdult-wrapper").css("display", "flex");
    }
    $("#adult").on("click", function (e) {
        e.preventDefault();
        localStorage.setItem("isAdult", true);
        $("#isAdult-wrapper").css("display", "none");
    });
});
//__________________________Cards__________________________//

$(".user-image .arrow").on("click", function (e) {
    e.preventDefault();
    e.stopPropagation();
});

//__________________________Sliders__________________________//

$(".img-slider").each(function () {
    var $slider = $(this);
    var $parent = $slider.closest(".user-image");

    $slider.slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        prevArrow: $parent.find(".prev"),
        nextArrow: $parent.find(".next"),
    });
});

//_________________________Popups___________________________//

const $popupWrapper = $(".popUp-wrapper");
const $header = $(".header");
const $cards = {
    signUp: $(".signUP-card"),
    logIn: $(".logIN-card"),
    resetPassword: $(".resetPassword-card"),
    resSuccesSend: $(".res-succes-send"),
    addNewPassCard: $(".addNew-pass-card"),
    passSucces: $(".pass-succes"),
    newEmail: $(".enter-new-email"),
    newPass: $(".add-new-pass"),
    passSuccesChanged: $("#pass-succes-changed"),
    emailSuccesChanged: $("#email-succes-changed"),
};

function togglePopup(cardName, show) {
    $popupWrapper.toggleClass("active", show);

    $("html").toggleClass("no-scroll", show);

    const isAuthPopup = $popupWrapper.hasClass("authPopup");

    if (!isAuthPopup) {
        $header.toggleClass("hidden", show && $(window).width() < 768);
    }

    Object.values($cards).forEach(($c) => $c.removeClass("active"));

    if (show) {
        $cards[cardName].addClass("active");
    }
}

$(".btn.login, .header-burger").on("click", () => togglePopup("logIn", true));
$(".btn.signup, .signup-link").on("click", () => togglePopup("signUp", true));
$(".login-link").on("click", () => togglePopup("logIn", true));
$(".reset-pass").on("click", () => togglePopup("resetPassword", true));
$(".close").on("click", () => togglePopup("", false));

$(".show-password").on("click", function () {
    const $passwordInput = $(this).closest(".input-group").find("input");
    const isPassword = $passwordInput.attr("type") === "password";
    $passwordInput.attr("type", isPassword ? "text" : "password");
    $(this).toggleClass("open", isPassword);
});

function enableSubmitButton($form) {
    const $inputs = $form.find('input[type="email"], input[type="password"]');
    const $submitButton = $form.find(".submit.btn");

    const checkInputs = () => {
        const allFilled = $inputs
            .toArray()
            .every((input) => $(input).val().trim() !== "");
        $submitButton.prop("disabled", !allFilled);
    };

    $inputs.on("input", checkInputs);

    checkInputs();
}

$(".signUP-card form, .logIN-card form, .resetPassword-card form").each(
    function () {
        enableSubmitButton($(this));
    }
);

//__________________________AJAX Setup_________________________//

$.ajaxSetup({
    beforeSend: (xhr) =>
        xhr.setRequestHeader(
            "X-CSRF-TOKEN",
            $('meta[name="csrf-token"]').attr("content")
        ),
});

//__________________________Loader_________________________//

function addLoader(selector, borderRadius) {
    $(selector).append(
        `<div class="loading" style="border-radius: ${borderRadius}"></div>`
    );
}

function removeLoader(selector) {
    $(selector).find(".loading").remove();
}

//__________________________Advertising_________________________//

if (DS.ads?.data && DS.ads?.settings) {
    const adPopup = {
        counters: {
            secs: 0,
            clicks: 0,
        },
        next: null,
        showing: false,
        interval: null,
        get secsCount() {
            return this.counters.secs;
        },
        set secsCount(count) {
            if (this.showing) {
                return;
            }

            if (count >= parseInt(DS.ads.settings.seconds_between_popups)) {
                this.showing = true;
                clearInterval(this.interval);
                this.show();
            } else {
                this.counters.secs = count;
            }
        },
        get clicksCount() {
            return this.counters.clicks;
        },
        set clicksCount(count) {
            if (this.showing) {
                return;
            }

            if (count >= parseInt(DS.ads.settings.clicks_between_popups)) {
                this.showing = true;
                clearInterval(this.interval);
                this.show();
            } else {
                this.counters.clicks = count;
            }
        },
        show() {
            if (!this.next) {
                return;
            }
            $("html").addClass("no-scroll");
            const popup = $(".advertising-wrapper");
            const img = $(".advertising-img");
            const link = $(".advertising-link");

            img.attr("src", this.next.image.url);
            link.data("id", this.next.id);
            link.attr("href", this.next.link);

            adCloseTimer.start(DS.ads.settings.close_popup_seconds);

            popup.addClass("show");

            this.getNext();
        },
        hide() {
            this.counters.secs = 0;
            this.counters.clicks = 0;

            this.interval = setInterval(() => {
                this.secsCount += 1;
            }, 1000);

            this.showing = false;
            $("html").removeClass("no-scroll");
            $(".advertising-wrapper").removeClass("show");
        },

        getNext() {
            if (!DS.ads.data.length) {
                return;
            }

            const min = 0;
            const max = DS.ads.data.length - 1;
            const rand = Math.floor(Math.random() * (max - min + 1)) + min;
            this.next = DS.ads.data[rand];

            this.predownloadNextImage();
        },
        predownloadNextImage() {
            const image = new Image();
            image.src = this.next.image.url;
        },
        ini() {
            this.getNext();

            $(".advertising-wrapper").on(
                "click",
                ".advertising-close-timer.enabled",
                () => {
                    this.hide();
                }
            );

            $(".users-item.profile-item").bind("click auxclick", () => {
                this.clicksCount += 1;
            });

            $(".advertising-link").bind("auxclick click", function () {
                $.post(`/ads/${$(this).data("id")}/click`);
            });

            this.interval = setInterval(() => {
                this.secsCount += 1;
            }, 1000);
        },
    };

    const adCloseTimer = {
        secs: 0,
        interval: null,
        start(secs) {
            const close = $(".advertising-close-timer");
            close.removeClass("enabled");
            close.addClass("disabled");

            const timer = $(".advertising-close-timer .timer");
            timer.text(secs);

            this.secs = secs;

            this.interval = setInterval(() => {
                this.secs--;

                timer.text(this.secs);

                if (this.secs <= 0) {
                    close.addClass("enabled");
                    close.removeClass("disabled");
                    clearInterval(this.interval);
                }
            }, 1000);
        },
    };

    adPopup.ini();
}

$(".users-item.add").bind("auxclick click", function () {
    $.post(`/ads/${$(this).data("id")}/click`);
});

$(".warning").bind("auxclick click", function () {
    $.post(`/warnings/${$(this).data("id")}/click`);
});

//__________________________Verification_________________________//

const resendTimer = {
    secs: 0,
    interval: null,
    start(secs) {
        this.secs = secs;

        this.interval = setInterval(() => {
            --this.secs;

            const formatted =
                (this.secs - (this.secs %= 60)) / 60 +
                (9 < this.secs ? ":" : ":0") +
                this.secs;
            $("#countdown").text(formatted);

            if (this.secs <= 0) {
                clearInterval(this.interval);
            }
        }, 1000);
    },
};

function openVerifyPopup(action, verifyUrl, resendUrl, email) {
    const verifyPopup = $(".verification-wrapper");

    verifyPopup.data("action", action);
    verifyPopup.data("verify_url", verifyUrl);
    verifyPopup.data("resend_url", resendUrl);

    verifyPopup.find(".email").text(email);

    verifyPopup.addClass("active");

    resendTimer.start(60);
}

$(".code-inputs input").each((index, input) => {
    $(input)
        .on("input", function () {
            if (isNaN(this.value)) {
                this.value = "";
                return;
            }

            if (
                this.value.length === 1 &&
                index < $(".code-inputs input").length - 1
            ) {
                $(".code-inputs input")
                    .eq(index + 1)
                    .focus();
            }
        })
        .on("keydown", function (e) {
            if (e.key === "Backspace" && index > 0 && this.value === "") {
                $(".code-inputs input")
                    .eq(index - 1)
                    .focus();
            }
        });
});

$(".code-inputs input").on("paste", (e) => {
    e.preventDefault();

    const inputs = $(".code-inputs input");

    let code = (e.originalEvent.clipboardData || window.clipboardData).getData(
        "text"
    );

    code.split("").forEach(
        (number, i) => !isNaN(number) && $(inputs[i]).val(number)
    );
});

$(".verification-wrapper input").on("input paste", async () => {
    const code = [];

    $(".code-inputs input").each(
        (i, input) => input.value && code.push(input.value)
    );

    if (code.length != 6) {
        return;
    }

    addLoader(".verification-container");

    const codeForm = $(".code-inputs");
    codeForm.removeClass("error");
    codeForm.find(".error-text").text("");

    const action = $(".verification-wrapper").data("action");
    const verifyUrl = $(".verification-wrapper").data("verify_url");

    const data = `code=${code.join("")}&recaptcha=${await getReCaptchaV3(
        action
    )}`;

    $.post(verifyUrl, data)
        .done(() => {
            $(".verification-wrapper").removeClass("active");

            $(document).trigger(`${action}-verified`);
        })
        .fail((err) => {
            codeForm.addClass("error");
            codeForm.find(".error-text").text(err.responseJSON.message);
        })
        .always(() => {
            removeLoader(".verification-container");
        });
});

$(".verification-wrapper .again").on("click", async () => {
    if (resendTimer.secs > 0) {
        return;
    }

    addLoader(".verification-container");

    $(".code-inputs input").each((i, input) => (input.value = ""));

    const codeForm = $(".code-inputs");
    codeForm.removeClass("error");
    codeForm.find(".error-text").text("");

    const action = $(".verification-wrapper").data("action");
    const resendUrl = $(".verification-wrapper").data("resend_url");

    const data = `recaptcha=${await getReCaptchaV3(action)}`;

    $.post(resendUrl, data)
        .done(() => {
            resendTimer.start(60);
        })
        .fail((err) => {
            codeForm.addClass("error");
            codeForm.find(".error-text").text(err.responseJSON.message);
        })
        .always(() => {
            removeLoader(".verification-container");
        });
});

//__________________________Errors_________________________//

function handleFail(form, xhr) {
    const error = form.closest(".card").find(".text-error");

    if (xhr.status == 422) {
        const errors = xhr.responseJSON.errors;

        for (const field in errors) {
            const input = form.find(`[name=${field}]`);

            if (!input.length || input.attr("type") == "hidden") {
                error.addClass("show").text(errors[field][0]);
            } else {
                input.closest(".input-group").addClass("error");
                input.next(".error-text").text(errors[field][0]);
            }
        }
    } else {
        error.addClass("show").text(xhr.responseJSON.message);
    }
}

function resetErrors(form) {
    form.find(".error").removeClass("error");
    form.closest(".card").find(".text-error").removeClass("show").text("");
}

//__________________________Sign Up_________________________//

$("#sign-up").submit(async function (e) {
    e.preventDefault();

    addLoader(".signUP-card");

    const form = $(this);

    resetErrors(form);

    const data =
        form.serialize() + `&recaptcha=${await getReCaptchaV3("signin")}`;

    $.post("/sign-up/send-code", data)
        .done(() => {
            togglePopup("signUp", false);

            openVerifyPopup(
                "sign_up",
                "/sign-up/verify-code",
                "/sign-up/resend-code",
                form.find("[name=email]").val()
            );
        })
        .fail((xhr) => {
            handleFail(form, xhr);
        })
        .always(() => {
            removeLoader(".signUP-card");
        });
});

$(document).on("sign_up-verified", () => {
    location.href = "/my-profile";
});

//__________________________Sign In_________________________//

$("#sign-in").submit(async function (e) {
    e.preventDefault();

    addLoader(".logIN-card");

    const form = $(this);

    resetErrors(form);

    const data =
        form.serialize() + `&recaptcha=${await getReCaptchaV3("signin")}`;

    $.post("/sign-in/send-code", data)
        .done(() => {
            togglePopup("logIn", false);

            openVerifyPopup(
                "sign_in",
                "/sign-in/verify-code",
                "/sign-in/resend-code",
                form.find("[name=email]").val()
            );
        })
        .fail((xhr) => {
            handleFail(form, xhr);
        })
        .always(() => {
            removeLoader(".logIN-card");
        });
});

$(document).on("sign_in-verified", () => {
    location.href = "/my-profile";
});

//__________________________Forgot Password_________________________//

$("#forgot-password").submit(async function (e) {
    e.preventDefault();

    addLoader(".resetPassword-card");

    const form = $(this);

    resetErrors(form);

    const data =
        form.serialize() + `&recaptcha=${await getReCaptchaV3("forgot")}`;

    $.post("/password/forgot", data)
        .done(() => {
            form[0].reset();

            togglePopup("resetPassword", false);

            $(".res-succes-send")
                .find(".mail")
                .text(form.find("[name=email]").val());
            togglePopup("resSuccesSend", true);
        })
        .fail((xhr) => {
            handleFail(form, xhr);
        })
        .always(() => {
            removeLoader(".resetPassword-card");
        });
});

$(".res-succes-send .btn").click(() => {
    togglePopup("resSuccesSend", false);
});

//__________________________Reset password_________________________//

$("#new-password-form").submit(async function (e) {
    e.preventDefault();

    addLoader(".addNew-pass-card");

    const form = $(this);

    resetErrors(form);

    const data =
        form.serialize() + `&recaptcha=${await getReCaptchaV3("forgot")}`;

    $.post("/password/reset", data)
        .done(() => {
            form[0].reset();

            togglePopup("addNewPassCard", false);

            togglePopup("passSucces", true);
        })
        .fail((xhr) => {
            handleFail(form, xhr);
        })
        .always(() => {
            removeLoader(".addNew-pass-card");
        });
});

//__________________________Favorites_________________________//

$(".likes").on("click", ".btn", function (e) {
    e.preventDefault();
    e.stopPropagation();

    const likes = $(this).closest(".likes").find(".likes-count");
    const id = $(this).closest(".likes").data("id");

    if ($(this).hasClass("active")) {
        $(this).removeClass("active");

        likes.text(parseInt(likes.text()) - 1);

        $.post("/favorites/remove", { favorite_id: id });
    } else {
        $(this).addClass("active");

        likes.text(parseInt(likes.text()) + 1);

        $.post("/favorites/add", { favorite_id: id });
    }
});

//__________________________Filters_________________________//

$("#filters-form").submit(function () {
    $(this)
        .find("input[name]")
        .filter((i, input) => !input.value)
        .prop("name", "");
});

//__________________________Change options_________________________//

$("#vote-battle, #account-visibility").bind("change", function () {
    const name = $(this).attr("name");
    const value = $(this).prop("checked");

    $.ajax({
        type: "PATCH",
        url: "/my-profile/switch-option",
        data: JSON.stringify({ name, value }),
        contentType: "application/json",
    });
});

//__________________________Delete profile_________________________//

$(".delete-acc").click(() => {
    $("#delete-popup").addClass("active");
});

$("#delete-popup #close-popup-btn").click(() => {
    $("#delete-popup").removeClass("active");
});

$("#delete-popup #confirm-delete:not(.load)").click(function () {
    $(this).addClass("load");

    $.ajax({
        type: "DELETE",
        url: "/my-profile",
    })
        .then(() => {
            location.href = "/my-profile/create";
        })
        .catch((jqXHR) => {
            alert(jqXHR.responseJSON.message);

            $(this).removeClass("load");
        });
});

//__________________________Roulette_________________________//

function initializeBattle($battle) {
    let nextPair = null;

    function getNextPair() {
        $.get("/roulette/get-pair").then((res) => {
            if (!res.pair) {
                return;
            }

            nextPair = res.pair;

            const predownloadPhoto = (url) => {
                const image = new Image();
                image.src = url;
            };

            predownloadPhoto(nextPair[0].gallery[0].url);
            predownloadPhoto(nextPair[1].gallery[0].url);
        });
    }

    getNextPair();

    function renderNextPair() {
        if (!nextPair) {
            return;
        }

        const html = (creator) => {
            return `
            <div class="photo-container photo" data-id="${creator.id}">
                <img src="${creator.gallery[0].url}">
                <div class="info">
                    ${
                        creator.name.length > 5
                            ? creator.name.substr(0, 5) + "..."
                            : creator.name
                    }, ${creator.age}
                </div>
            </div>`;
        };

        $battle.find(".photo:first").replaceWith(html(nextPair[0]));
        $battle.find(".photo:last").replaceWith(html(nextPair[1]));
    }

    function vote(id) {
        $.post(`/roulette/vote/${id}`);
    }

    const $circle = $battle.find(".progress-ring__circle");
    const radius = $circle[0].r.baseVal.value;
    const circumference = 2 * Math.PI * radius;

    $circle.css({
        strokeDasharray: circumference,
        strokeDashoffset: circumference,
    });

    let hasSelected = false;

    $battle.find(".start_btn").click(function () {
        const $this = $(this);
        $this.closest(".startBattle").addClass("hidden");
        startProgressAnimation($circle, DS.ads.settings.repeat_time * 1000);
        setTimeout(
            () => activateRepeatButton($this),
            DS.ads.settings.repeat_time * 1000
        );
    });

    $battle.on("click", ".photo", function () {
        const $selectedPhoto = $(this);

        if ($selectedPhoto.hasClass("selected")) {
            window.open(`/profile/${$selectedPhoto.data("id")}`, "_blank");
        }

        if (!hasSelected) {
            const $blurredPhoto = $battle.find(".photo").not($selectedPhoto);
            selectPhoto($selectedPhoto, $blurredPhoto);
            hasSelected = true;
            vote($selectedPhoto.data("id"));
        }
    });

    $battle.on("click", ".repeat.active", function () {
        setTimeout(() => {
            renderNextPair();
            hasSelected = false;
            getNextPair();
        }, 500);

        const $this = $(this);
        const $loader = $battle.find(".loader");

        $this.removeClass("active");
        $loader.addClass("open");

        setTimeout(() => {
            $loader.removeClass("open");
        }, 1500);

        restartProgressAnimation($circle, DS.ads.settings.repeat_time * 1000);
        setTimeout(
            () => activateRepeatButton($this),
            DS.ads.settings.repeat_time * 1000 + 1500
        );
    });

    function startProgressAnimation($circle, duration) {
        setTimeout(() => {
            $circle.css({
                transition: `stroke-dashoffset ${duration / 1000}s linear`,
                strokeDashoffset: "0",
            });
        }, 0);
    }

    function restartProgressAnimation($circle, duration) {
        $circle.css({
            transition: "none",
            strokeDashoffset: circumference,
        });

        setTimeout(() => {
            startProgressAnimation($circle, duration);
        }, 1500);
    }

    function activateRepeatButton($button) {
        $button.closest(".battle").find(".repeat").addClass("active");
    }

    function selectPhoto($selectedPhoto, $blurredPhoto) {
        $selectedPhoto.addClass("selected").removeClass("blurred");
        $blurredPhoto.addClass("blurred").removeClass("selected");

        $selectedPhoto.find(".info").text("Click to open profile");
    }
}

$(".battle").each(function () {
    initializeBattle($(this));
});

//__________________________New email_________________________//

$("#change-email-form").submit(async function (e) {
    e.preventDefault();

    addLoader(".enter-new-email");

    const form = $(this);

    resetErrors(form);

    const data =
        form.serialize() + `&recaptcha=${await getReCaptchaV3("change_email")}`;

    $.post("/change-email/send-code", data)
        .done(() => {
            form[0].reset();

            togglePopup("newEmail", false);

            openVerifyPopup(
                "change_email",
                "/change-email/verify-code",
                "/change-email/resend-code",
                $(".current.email").text()
            );
        })
        .fail((xhr) => {
            handleFail(form, xhr);
        })
        .always(() => {
            removeLoader(".enter-new-email");
        });
});

$(document).on("change_email-verified", () => {
    togglePopup("emailSuccesChanged", true);
});

$(".reset-btn.email").click(() => {
    togglePopup("newEmail", true);
});

$("#pass-succes-changed .btn").click(() => {
    togglePopup("passSuccesChanged", false);
});

//__________________________New password_________________________//

$("#change-password-form").submit(async function (e) {
    e.preventDefault();

    addLoader(".add-new-pass");

    const form = $(this);

    resetErrors(form);

    const data =
        form.serialize() +
        `&recaptcha=${await getReCaptchaV3("change_password")}`;

    $.post("/change-password", data)
        .done(() => {
            form[0].reset();

            togglePopup("passSuccesChanged", true);
        })
        .fail((xhr) => {
            handleFail(form, xhr);
        })
        .always(() => {
            removeLoader(".add-new-pass");
        });
});

$(".reset-btn.pass").click(() => {
    togglePopup("newPass", true);
});

$("#email-succes-changed .btn").click(() => {
    togglePopup("emailSuccesChanged", false);
});

//__________________________FAQ__________________________//
$(".open-faq").click(function () {
    $(".sidebar").toggleClass("open");
});

$(document).ready(function () {
    $(".accordion-open").click(function () {
        $(this).closest(".accordion").toggleClass("active");
        var panel = $(this).next(".accordion-pannel");
        panel.slideToggle();
    });
    $(".accordion-item").click(function () {
        $(".accordion-item").removeClass("open");
        $(".sidebar-menu-item").removeClass("open");
        $(this).addClass("open");
        $(this).closest(".accordion").addClass("open");
    });
    $(".sidebar-menu-item").click(function () {
        if (!$(this).hasClass("accordion")) {
            $(".accordion-item").removeClass("open");
            $(".sidebar-menu-item").removeClass("open");
            $(this).addClass("open");
        }
    });
    $("[data-target]").click(function (event) {
        event.preventDefault();
        var targetId = $(this).data("target");
        $(".faq-content").hide();
        $("#" + targetId).show();
        updateMenuClasses(targetId);
    });

    $(".faq-next").click(function () {
        var current = $(".faq-content:visible");
        var next = current.next(".faq-content");
        if (next.length === 0) {
            next = $(".faq-content").first();
        }
        showContent(next.attr("id"));
    });

    $(".faq-prev").click(function () {
        var current = $(".faq-content:visible");
        var prev = current.prev(".faq-content");
        if (prev.length === 0) {
            prev = $(".faq-content").last();
        }
        showContent(prev.attr("id"));
    });

    function showContent(targetId) {
        $(".faq-content").hide();
        $("#" + targetId).show();
        updateMenuClasses(targetId);
    }

    function updateMenuClasses(targetId) {
        $(".accordion-item").removeClass("open");
        $(".sidebar-menu-item").removeClass("open");
        var targetLink = $('[data-target="' + targetId + '"]');
        targetLink.addClass("open");
        var accordion = targetLink.closest(".accordion");

        if (accordion.length) {
            accordion.addClass("open");
            accordion.find(".accordion-pannel").slideDown();
        } else {
            $(".accordion").removeClass("active");
            $(".accordion-pannel").slideUp();
        }
    }
});
$(document).ready(function () {
    $(".search-input").on("input", function () {
        var query = $(this).val().toLowerCase().trim();
        var $searchResult = $(".search-result");
        $searchResult.empty();

        if (query) {
            $(".faq-content").each(function () {
                var $this = $(this);
                var content = $this.text();
                var contentLower = content.toLowerCase();
                var id = $this.attr("id");
                var re = new RegExp(query, "gi");
                var match;
                var results = [];

                while ((match = re.exec(contentLower)) !== null) {
                    var start = Math.max(0, match.index - 20);
                    var end = Math.min(
                        content.length,
                        match.index + query.length + 70
                    );

                    var snippet = content.substring(start, end);

                    var highlightedSnippet = snippet.replace(
                        new RegExp(query, "gi"),
                        function (match) {
                            return (
                                "<span class='highlight'>" + match + "</span>"
                            );
                        }
                    );

                    results.push({
                        snippet: highlightedSnippet,
                        id: id,
                    });
                }

                results.forEach(function (result) {
                    $searchResult.append(
                        '<div class="result-item" data-target="' +
                            result.id +
                            '">' +
                            result.snippet +
                            "...</div>"
                    );
                });
            });

            $searchResult.show();
        } else {
            $searchResult.hide();
        }
    });
    $(document).on("click", function (event) {
        if (!$(event.target).closest(".search-wrapper").length) {
            $(".search-result").hide();
        }
    });

    $(".search-wrapper").on("click", function (event) {
        event.stopPropagation();
    });

    $(".search-result").on("click", ".result-item", function () {
        var targetId = $(this).data("target");

        $(".faq-content").hide();

        $("#" + targetId).show();

        $(".search-result").hide();

        $(".sidebar-menu-item, .accordion-item")
            .removeClass("open")
            .removeClass("active");

        var $targetSidebarItem = $(
            ".sidebar-menu-item[data-target='" + targetId + "']"
        );
        if ($targetSidebarItem.length) {
            $targetSidebarItem.addClass("open");
        } else {
            var $targetAccordionItem = $(
                ".accordion-item[data-target='" + targetId + "']"
            );
            if ($targetAccordionItem.length) {
                $targetAccordionItem.addClass("open");
                $targetAccordionItem.closest(".accordion-pannel").slideToggle();
                $targetAccordionItem.closest(".accordion").addClass("open");
                $targetAccordionItem.closest(".accordion").addClass("active");
            }
        }
    });
});
$(document).ready(function () {
    if ($("header .advertising-banner").length) {
        $(".open-faq").css("top", "93px");
        $(".sidebar.open").css("top", "93px");
    } else {
        $(".open-faq").css("top", "60px");
        $(".sidebar.open").css("top", "60px");
    }
});
$(document).on("click", ".sidebar-menu-item", function () {
    $(".sidebar").removeClass("open");
});

//__________________________Transactions__________________________//

$(".open-transaction").click(() => {
    $(".transaction-wrapper").toggleClass("active");
});

$(".transaction-wrapper .close").click(() => {
    $(".transaction-wrapper").toggleClass("active");
});

//__________________________Subscribe__________________________//

$(document).on("click", ".subscribe-Btn:not(.after,.loading)", () => {
    addLoader(".subscribe-Btn", "6px");

    $(".subscribe-Btn").addClass("loading");
    $(".subscribe-card .text-error").removeClass("show");

    $.post("/subscribe")
        .done(() => {
            location.reload();
        })
        .fail((xhr) => {
            $(".subscribe-card .text-error")
                .text(xhr.responseJSON.message)
                .addClass("show");
        })
        .always(() => {
            $(".subscribe-Btn").removeClass("loading");
            removeLoader(".subscribe-Btn");
        });
});

$(".un-subscribe-Btn").on("click", () => {
    $(".unsubcribe-wrapper .text span").text($(".renewal span").text());
    $(".unsubcribe-wrapper").addClass("active");
});

$(".unsubcribe-wrapper .close").on("click", () => {
    $(".unsubcribe-wrapper").removeClass("active");
});

$(".unsubcribe-wrapper .btn").on("click", () => {
    $(".unsubcribe-wrapper").removeClass("active");

    addLoader(".un-subscribe-Btn", "6px");

    $(".subscribe-card .text-error").removeClass("show");

    $.post("/unsubscribe")
        .done(() => {
            location.reload();
        })
        .fail((xhr) => {
            $(".subscribe-card .text-error")
                .text(xhr.responseJSON.message)
                .addClass("show");
        })
        .always(() => {
            removeLoader(".un-subscribe-Btn");
        });
});

//__________________________Deposit__________________________//

const deposit = {
    currency: null,
};

// curency
$(".deposit-type").on("click", async function () {
    deposit.currency = $(this).data("currency");

    addLoader(`[data-currency=${deposit.currency}]`, "4px");

    $.post("/payments/deposit", {
        gateway: "plisio",
        currency: deposit.currency,
        recaptcha: await getReCaptchaV3("deposit"),
    })
        .done((res) => {
            $(".coins-wrapper").removeClass("active");

            $(".qr-code img").attr("src", res.details.qr_code);
            $(".network .type").text(res.details.currency);
            $(".course span").text(
                `1 USD - ${res.details.source_rate} ${res.details.currency}`
            );
            $(".key .title").text(res.details.wallet_hash);
            $(".deposit-wrapper").addClass("active");
        })
        .always(() => {
            removeLoader(`[data-currency=${deposit.currency}]`);
        });
});

$(".copy").on("click", () => {
    let keyText = $(".key .title").text();

    let $tempInput = $("<input>");
    $("body").append($tempInput);
    $tempInput.val(keyText).select();
    document.execCommand("copy");
    $tempInput.remove();

    $(".message").show().delay(2000).fadeOut();
});

$(".coins-wrapper .close").click(() => {
    $(".coins-wrapper").toggleClass("active");
});

$(".deposit-wrapper .close").click(() => {
    $(".deposit-wrapper").toggleClass("active");
});

//__________________________Withdraw__________________________//

const withdraw = {
    currency: null,
    to: null,
    amount: null,
};

// currency
$(".referral-out").on("click", function () {
    withdraw.currency = $(this).data("currency");

    $(".crypto-address .network-icon").attr(
        "src",
        $(this).find("img").attr("src")
    );
    $(".crypto-address .crypto-name span").text(withdraw.currency);
    $(".crypto-address .crypto-rate span").text(DS.rates[withdraw.currency]);
    $(".referral-out-wrapper").addClass("active");
    $(".referral-out-wrapper .card").removeClass("active");
    $(".crypto-address").addClass("active");
});

// to, amount
$(".crypto-address .next").on("click", () => {
    withdraw.to = $("#cryptoAddress").val();
    withdraw.amount = parseInt($("#amount").val());

    $(".crypto-address-input").removeClass("error");
    $(".amount-input").removeClass("error");

    let valid = true;

    if (!withdraw.to) {
        $(".crypto-address-input").addClass("error");
        $(".crypto-address-input")
            .find(".error-text")
            .text("Address is required");
        valid = false;
    }

    if (!withdraw.amount) {
        $(".amount-input").addClass("error");
        $(".amount-input").find(".error-text").text("Amount is required");
        valid = false;
    }

    const max = parseInt($("#amount").attr("max"));

    if (withdraw.amount > max) {
        $(".amount-input").addClass("error");
        $(".amount-input").find(".error-text").text("Not enough Coins");
        valid = false;
    }

    if (!valid) {
        return;
    }

    $(".crypto-address").removeClass("active");

    $(".withdrawn-details .to").text(withdraw.to);
    $(".withdrawn-details .currency").text(withdraw.currency);
    $(".withdrawn-details .amount").text(
        `${withdraw.amount} USD - ${
            withdraw.amount * DS.rates[withdraw.currency]
        } ${withdraw.currency}`
    );
    $(".withdrawn-details").addClass("active");
});

// details
$(".withdrawn-details .next").on("click", async () => {
    addLoader(".withdrawn-details");

    $.post("/payments/withdraw/send-code", {
        ...withdraw,
        gateway: "plisio",
        recaptcha: await getReCaptchaV3("withdraw"),
    })
        .done(() => {
            $(".referral-out-wrapper").removeClass("active");
            $(".withdrawn-details").removeClass("active");

            openVerifyPopup(
                "withdraw",
                "/payments/withdraw/verify-code",
                "/payments/withdraw/resend-code",
                $(".user-mail").text()
            );
        })
        .always(() => {
            removeLoader(".withdrawn-details");
        });
});

$(document).on("withdraw-verified", () => {
    $(".referral-out-wrapper").addClass("active");
    $(".withdrawn-final").addClass("active");
});

$(".withdrawn-final .btn").on("click", async () => {
    $(".referral-out-wrapper").removeClass("active");
});

$(".referral-out-wrapper .back").on("click", function () {
    const card = $(this).closest(".card");

    card.removeClass("active");
    card.prev().addClass("active");

    if (card.hasClass("crypto-address")) {
        $(".referral-out-wrapper").removeClass("active");
    }
});

$(".referral-out-wrapper .close").on("click", () => {
    $(".referral-out-wrapper").removeClass("active");
});

$(".load-more img").on("click", () => {
    $(".referal-item.none").each((i, item) => {
        if (i > 9) {
            return;
        }

        $(item).removeClass("none");
    });

    if (!$(".referal-item.none").length) {
        $(".load-more").addClass("none");
    }
});

$(".copy-link").on("click", () => {
    let linkText = $(".link-body .link").text();

    let $tempInput = $("<input>");
    $("body").append($tempInput);
    $tempInput.val(linkText).select();
    document.execCommand("copy");
    $tempInput.remove();

    $(".link-body .message").show().delay(2000).fadeOut();
});

$(document).ready(function () {
    function togglePasteButton() {
        if ($("#cryptoAddress").val().trim() !== "") {
            $("#pasteButton").hide();
        } else {
            $("#pasteButton").show();
        }
    }
    togglePasteButton();

    $("#pasteButton").on("click", function () {
        navigator.clipboard.readText().then((text) => {
            $("#cryptoAddress").val(text);
            togglePasteButton();
        });
    });
    $("#cryptoAddress").on("input", function () {
        togglePasteButton();
    });
});

$(document).ready(function () {
    $(".max-amount").on("click", function () {
        console.error("Max amount is not defined");
    });
});
