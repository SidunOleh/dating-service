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
    $(".verification-wrapper").css("top", `${headerHeight}px`);
    $(".advertising-wrapper").css("top", `${headerHeight}px`);
    $(".deposit-wrapper").css("top", `${headerHeight}px`);
    $(".referral-out-wrapper").css("top", `${headerHeight}px`);
    $(".popUp-wrapper").css("top", `${headerHeight}px`);
    $(".transaction-wrapper").css("top", `${headerHeight}px`);
    $(".open-faq").css("top", "104px");
    $(".sidebar").css("top", "93px");
} else {
    $(".header-menu").css("height", `100vh`);
    $(".open-faq").css("top", `72px`);
    $(".sidebar").css("top", "60px");
}
$(".closePage").on("click", function () {
    window.close();
});

if ($(".popUp-wrapper").hasClass("active")) {
    $("html").addClass("lock");
} else {
    $("html").removeClass("lock");
}
if ($(".advertising-wrapper").hasClass("show")) {
    $("html").addClass("lock");
} else {
    $("html").removeClass("lock");
}
if ($(".referral-out-wrapper").hasClass("active")) {
    $("html").addClass("lock");
} else {
    $("html").removeClass("lock");
}

$(document).ready(function () {
    if (!localStorage.getItem("isAdult")) {
        $("#isAdult-wrapper").css("display", "flex");
        $("html").addClass("lock");
    }
    $("#adult").on("click", function (e) {
        e.preventDefault();
        localStorage.setItem("isAdult", true);
        $("#isAdult-wrapper").css("display", "none");
        $("html").removeClass("lock");
    });
});
$(".max-amount").click(function () {
    var maxAmount = $("#amount").attr("max");
    if (maxAmount) {
        $("#amount").val(maxAmount);
    } else {
        console.error("Max amount is not defined");
    }
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

    if ($slider.children().length <= 1) {
        $parent.find(".prev, .next").hide();
    } else {
        $slider.slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            prevArrow: $parent.find(".prev"),
            nextArrow: $parent.find(".next"),
        });
    }
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

$(document).on("click", ".btn.login, .header-burger", () => togglePopup("logIn", true));
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
                    $(".advertising-link").removeAttr("clicked");
                    this.hide();
                }
            );

            $(".users-item.profile-item").bind("click auxclick", () => {
                this.clicksCount += 1;
            });

            $(".advertising-link").bind("auxclick click", function () {
                if ($(this).attr("clicked") != 'true') {
                    $(this).attr("clicked", 'true');
                    $.post(`/ads/${$(this).data("id")}/click`);
                }
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

$(".verification-container .close").click(function () {
    $(".verification-wrapper").removeClass("active");
});

const resendTimer = {
    secs: 0,
    interval: null,
    start(secs) {
        if (this.interval) {
            clearInterval(this.interval);
        }

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
    $("html").addClass("lock");
    resendTimer.start(60);
}

const codeInputs = [...document.querySelectorAll(".code-inputs input")];

codeInputs.forEach((codeInput, i) => {
    codeInput.addEventListener("keydown", (e) => {
        if (e.keyCode === 8 && e.target.value === "") {
            codeInputs[Math.max(0, i - 1)].focus();
        }
    });

    codeInput.addEventListener("input", (e) => {
        const [first, ...rest] = e.target.value;

        e.target.value = first ?? "";

        if (first !== undefined && i !== codeInputs.length - 1) {
            codeInputs[i + 1].focus();
            codeInputs[i + 1].value = rest.join("");
            codeInputs[i + 1].dispatchEvent(new Event("input"));
        }
    });
});

$(".verification-wrapper input:last").on("input paste", async () => {
    const code = [];

    $(".code-inputs input").each(
        (i, input) => input.value && code.push(input.value)
    );

    if (code.length != 3) {
        return;
    }

    addLoader(".verification-container");

    const codeForm = $(".code-inputs");
    codeForm.removeClass("error");
    codeForm.find(".error-text").text("");

    const action = $(".verification-wrapper").data("action");
    const verifyUrl = $(".verification-wrapper").data("verify_url");

    const data = `code=${code.join("")}`;

    $.post(verifyUrl, data)
        .done(() => {
            $(".verification-wrapper").removeClass("active");
            $("html").removeClass("lock");
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

    const resendUrl = $(".verification-wrapper").data("resend_url");

    $.post(resendUrl)
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

    const data = form.serialize();

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
    location.reload()
});

//__________________________Sign In_________________________//

$("#sign-in").submit(async function (e) {
    e.preventDefault();

    addLoader(".logIN-card");

    const form = $(this);

    resetErrors(form);

    const data = form.serialize();

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
    location.reload()
});

//__________________________Forgot Password_________________________//

$("#forgot-password").submit(async function (e) {
    e.preventDefault();

    addLoader(".resetPassword-card");

    const form = $(this);

    resetErrors(form);

    const data = form.serialize();

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

    const data = form.serialize();

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

$(".delete-profile #close-popup-btn").click(() => {
    $("#delete-popup").removeClass("active");
});

$(".delete-profile #confirm-delete:not(.load)").click(function () {
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
                    ${creator.city}, ${creator.state}
                </div>
            </div>`;
        };

        $battle.find(".photo:first").replaceWith(html(nextPair[0]));
        $battle.find(".photo:last").replaceWith(html(nextPair[1]));

        // Призначаємо класи після заміни
        $battle.find(".photo:first .info").addClass("right");
        $battle.find(".photo:last .info").addClass("left");
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
            window.open(`/${$selectedPhoto.data("id")}`, "_blank");
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
        }, 750);

        restartProgressAnimation($circle, DS.ads.settings.repeat_time * 1000);
        setTimeout(
            () => activateRepeatButton($this),
            DS.ads.settings.repeat_time * 1000 + 750
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
        }, 750);
    }

    function activateRepeatButton($button) {
        $button.closest(".battle").find(".repeat").addClass("active");
    }

    function selectPhoto($selectedPhoto, $blurredPhoto) {
        $selectedPhoto.addClass("selected").removeClass("blurred");
        $blurredPhoto.addClass("blurred").removeClass("selected");

        // $selectedPhoto.find(".info").text("Click to open profile");
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

    const data = form.serialize();

    $.post("/change-email/send-code", data)
        .done(() => {
            togglePopup("newEmail", false);

            openVerifyPopup(
                "change_email",
                "/change-email/verify-code",
                "/change-email/resend-code",
                $(this).find("[name=new_email]").val()
            );

            form[0].reset();
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

    location.reload();
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

    const data = form.serialize();

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
$(document).ready(function () {
    function openTargetFromURL() {
        const urlParams = new URLSearchParams(window.location.search);
        const targetId = urlParams.get("target");
        if (targetId) {
            showContent(targetId);
        }
    }
    $(".open-faq").click(function () {
        $(".sidebar").toggleClass("open");
        $("html").addClass("lock");
    });

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
        showContent(targetId);
    });
    $(".faq-next").click(function () {
        var current = $(".faq-content:visible");
        var next = current.next(".faq-content");
        if (next.length === 0) {
            next = $(".faq-content").first();
        }
        showContent(next.attr("id"));
        $(window).scrollTop(0);
    });

    $(".faq-prev").click(function () {
        var current = $(".faq-content:visible");
        var prev = current.prev(".faq-content");
        if (prev.length === 0) {
            prev = $(".faq-content").last();
        }
        showContent(prev.attr("id"));
        $(window).scrollTop(0);
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
    $(".search-input").on("input", function () {
        var query = $(this).val().toLowerCase().trim();
        displaySearchResults(query);
    });

    $(".search-input").on("focus", function () {
        var query = $(this).val().toLowerCase().trim();
        if (query) {
            $(".search-result").show();
        }
    });

    function displaySearchResults(query) {
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
    }

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
        showContent(targetId);
        $(".search-result").hide();
    });

    openTargetFromURL();
});

$(document).on("click", ".sidebar-menu-item", function () {
    if (!$(this).hasClass("accordion")) {
        $(".sidebar").removeClass("open");
        $("html").removeClass("lock");
    }
});

$(document).on("click", ".accordion-item", function () {
    $(".sidebar").removeClass("open");
    $("html").removeClass("lock");
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
    payment_id: null,
};

let depositQR = null;

if (document.getElementById("deposit-qr")) {
    depositQR = new QRCode(document.getElementById("deposit-qr"), "");
}

// curency
$(".deposit-type").on("click", async function () {
    deposit.payment_id = $(this).data("payment_id");

    addLoader(`[data-payment_id=${deposit.payment_id}]`, "4px");

    $.post("/payments/deposit", {
        gateway: "crypto",
        payment_id: deposit.payment_id,
    })
        .done((res) => {
            $(".coins-wrapper").removeClass("active");
            $(".deposit-popup .network-icon").attr(
                "src",
                $(this).find("img").attr("src")
            );
            $(".deposit-popup .crypto-name span").text($(this).data("network"));

            depositQR.clear();
            depositQR.makeCode(res.details.address_to);

            $(".network .type").text($(this).data("currency"));
            $(".deposit-wrapper .crypto-rate span").text(
                `${1 / DS.rates[deposit.payment_id]} ${$(this).data(
                    "currency"
                )}`
            );
            $(".key .title").text(res.details.address_to);
            $(".deposit-wrapper").addClass("active");
        })
        .always(() => {
            removeLoader(`[data-payment_id=${deposit.payment_id}]`);
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
    payment_id: null,
    address_to: null,
    amount: null,
};

// currency
$(".referral-out").on("click", function () {
    withdraw.payment_id = $(this).data("payment_id");
    var fullText = $(this).find(".name").text().trim();
    var shortText = $(this).find(".abbr").text().trim();
    $(".crypto-address .network-icon").attr(
        "src",
        $(this).find("img").attr("src")
    );
    $(".crypto-address .crypto-name .full").text(fullText);
    $(".crypto-address .crypto-name .short").text(shortText);
    $(".crypto-address .crypto-rate span").text(
        `${1 / DS.rates[withdraw.payment_id]} ${$(this).data("currency")}`
    );
    $(".referral-out-wrapper").addClass("active");
    $(".referral-out-wrapper .card").removeClass("active");
    $("html").addClass("lock");
    $(".crypto-address").addClass("active");
});

// to, amount
$(".crypto-address .next").on("click", async () => {
    withdraw.address_to = $("#cryptoAddress").val();
    withdraw.amount = parseInt($("#amount").val());

    $(".crypto-address-input").removeClass("error");
    $(".amount-input").removeClass("error");
    $(".crypto-address .text-error").removeClass("show");

    let valid = true;

    if (!withdraw.address_to) {
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

    addLoader(".crypto-address");

    $.post("/payments/withdraw/send-code", {
        ...withdraw,
        gateway: "crypto",
    })
        .done(() => {
            $(".referral-out-wrapper").removeClass("active");
            $(".crypto-address").removeClass("active");

            openVerifyPopup(
                "withdraw",
                "/payments/withdraw/verify-code",
                "/payments/withdraw/resend-code",
                $(".user-mail").text()
            );
        })
        .fail((xhr) => {
            $(".crypto-address .text-error")
                .text(xhr.responseJSON.message)
                .addClass("show")
        })
        .always(() => {
            removeLoader(".crypto-address");
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
    $("html").removeClass("lock");
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
        if ($("#cryptoAddress").val()?.trim() !== "") {
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
    $("#description").on("input", function () {
        var descriptionLength = $(this).val().length;
        $(".counter").text(descriptionLength);

        if (descriptionLength <= 250) {
            $(".counter").css("color", "red");
        } else {
            $(".counter").css("color", "#dedfe1");
        }
    });
});

//__________________________Swap__________________________//

$('.buy-meow-btn .buy').on('click', async function () {
    $('.swaps .text-error').removeClass('show')

    let balance1 = $(this).data('balance-1')
    let balance2 = $(this).data('balance-2')

    if (balance1 < 1) {
        $('.swaps .text-error').text('Not enough Coins :(').addClass('show')
        return
    }

    $('.buy-meow-btn').append('<div class="added">+1 added</div>')

    balance1 -= 1
    balance2 += 1
    updateBalances(balance1, balance2)

    try {
        await $.post('/balances/transfer')
    } catch (err) {
        console.error(err)

        $('.swaps .text-error').text(err.responseJSON?.message ?? 'Error').addClass('show')

        balance1 += 1
        balance2 -= 1
        updateBalances(balance1, balance2)
    }
})

function updateBalances(balance1, balance2) {
    $('[data-balance-1]').data('balance-1', balance1)
    $('[data-balance-2]').data('balance-2', balance2)
    $('.balance-1').text(format_price(balance1))
    $('.balance-2').text(format_price(balance2))
    $('.balance-2.rich').text(balance2 >= 100 ? 'Rich' : format_price(balance2))
    $('.exchange-form #amount').attr('max', balance2)
}

function format_price(amount) {
    return (Math.round(amount * 100) / 100).toFixed(2)
}

//__________________________Posts__________________________//

$(document).on('click', '.post__btns:not(.opening) .paw-btn:not(.clicked):not(.shaking)', function () {
    const start = new Date().getTime()

    const buttonNumber = $(this).data('number')
    const post = $(this).closest('.post')
    const postId = post.data('id')

    $(this).addClass('shaking')
    $(this).closest('.post__btns').addClass('opening')

    $.post(`/posts/${postId}/open`, {button_number: buttonNumber})
        .done(res => {
            const time = Date.now() - start
            if (time < 1500) {
                sleep(1500 - time)
            } 

            post.addClass('flash')

            setTimeout(() => {
                post.removeClass('flash')

                $(this).addClass('clicked')
            
                updateBalances(res.balance, res.balance_2)

                const tryCount = post.find('.paw-btn.clicked').length
    
                if (res.open && tryCount == 1) {
                    post.find('.alert.success').addClass('show')
                    setTimeout(() => {
                        post.find('.alert.success').removeClass('show')
                        post.replaceWith(res.html)
                    }, 1000)
                } 

                if (res.open && tryCount > 1) {
                    post.replaceWith(res.html)
                }
                
                if (! res.open) {
                    post.find('.alert.fail').addClass('show')
                    setTimeout(() => {
                        post.find('.alert.fail').removeClass('show')
                    }, 1000)
                }
            }, 70)
        })
        .fail(xhr => {
            const time = Date.now() - start
            if (time < 1500) {
                sleep(1500 - time)
            }

            $(this).closest('.post').find('.error').text(xhr.responseJSON.message)
        })
        .always(() => {
            $(this).removeClass('shaking')
            $(this).closest('.post__btns').removeClass('opening')
        })
})

function loadMorePosts() {
    if ($('.posts').hasClass('load')) {
        return
    }

    if (! $('.posts__list').length) {
        return
    }

    const currentPage = $('.posts__list').data('current-page')
    const totalPages = $('.posts__list').data('total-pages')

    if (currentPage >= totalPages) {
        return
    }

    $('.posts').addClass('load')

    const nextPage = currentPage + 1

    let url = ''
    if ($('.tab').hasClass('tab_myprofile')) {
        url = `/posts/my-profile/load-more?page=${nextPage}`
    } else {
        url = `/posts/${$('.posts__list').data('creator-id')}/load-more?page=${nextPage}`
    }

    $.get(url)
        .done(res => {
            $('.posts__list').data('current-page', nextPage)
            $('.posts__list').append(res.html)
        })
        .always(() => {
            $('.posts').removeClass('load')
        })
}

$(window).scroll(() => {
    if($(window).scrollTop() + $(window).height() > $(document).height() - 100 
        && $('.tab__right').hasClass('open')) {
        loadMorePosts()
    }
})

$(document).on('click', '.post__close', function () {
    $('.delete-post').data('id', $(this).closest('.post').data('id'))
    $('.delete-post').addClass('active')
})

$(document).on('click', '.delete-post #close-popup-btn', function () {
    $('.delete-post').removeClass('active')
})

$(document).on('click', '.delete-post #confirm-delete', function () {
    const postId = $('.delete-post').data('id')

    const post = $(`.post[data-id=${postId}]`)

    if (post.hasClass('loading')) {
        return
    }

    $(this).addClass('load')

    $.ajax({method: 'DELETE', url: `/posts/${postId}`})
        .done(() => {
            post.remove()
            $('.delete-post').removeClass('active')
        })
        .always(() => {
            $(this).removeClass('load')
        })
})

//__________________________Tabs__________________________//

function openTab(tab) {
    $('[data-tab]').removeClass('open')
    $(`[data-tab=${tab}]`).addClass('open')
    const url = new URL(window.location.href)
    url.searchParams.set('tab', tab)
    window.history.pushState({}, '', url.toString())
    $('.tab').addClass('flash')
    setTimeout(() => $('.tab').removeClass('flash'), 100)
    for (let i = 0; i < 2; i++) {
        setTimeout(() => window.dispatchEvent(new Event('resize')), i*500)
    }
}

$('.tab__head').on('click', function () {
    const tab = $(this).data('head')
    openTab(tab)
})

$('.tab__item').on('click', function () {
    if ($(this).hasClass('open')) {
        return
    }
    $('.tab__item').removeClass('open')
    $(this).addClass('open')
    const tab = $(this).data('head')
    openTab(tab)
})

//__________________________Functions__________________________//

function sleep(milliseconds) {
    let start = new Date().getTime()
    for (var i = 0; i < 1e7; i++) {
        if ((new Date().getTime() - start) > milliseconds) {
            break
        }
    }
}