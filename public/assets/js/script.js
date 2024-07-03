Fancybox.bind("[data-fancybox]", {});

//__________________________HEADER__________________________//

$(".burger-menu").click(function() {
    $(".header-menu").toggleClass("open");
});

$(".header-menu .close").click(function() {
    $(".header-menu").removeClass("open");
});

//__________________________USERS__________________________//

$(".user-image .arrow").on("click", function(event) {
    event.preventDefault();
    event.stopPropagation();
});

//__________________________SLIDERS__________________________//

$(".img-slider").each(function() {
    var $slider = $(this);
    var $parent = $slider.closest(".user-image");

    $slider.slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        prevArrow: $parent.find(".prev"),
        nextArrow: $parent.find(".next"),
    });
});

//_____________________SIGN-UP_LOG-IN______________________//

const popupWrapper = document.querySelector(".popUp-wrapper");
const signUpCard = document.querySelector(".signUP-card");
const logInCard = document.querySelector(".logIN-card");
const resetPasswordCard = document.querySelector(".resetPassword-card");
const loginBtn = $(".btn.login");
const signupBtn = document.querySelector(".btn.signup");
const burgerMenu = document.querySelector(".header-burger");
const closeButtons = document.querySelectorAll(".close");
const signupLink = document.querySelector(".signup-link");
const resetPassLink = document.querySelector(".reset-pass");
const header = document.querySelector(".header");

function openPopup(card) {
    popupWrapper.classList.add("active");
    document.documentElement.classList.add("no-scroll");
    signUpCard.classList.remove("active");
    logInCard.classList.remove("active");
    resetPasswordCard.classList.remove("active");
    card.classList.add("active");
    if (window.innerWidth < 768) {
        header.classList.add("hidden");
    }
}

function closePopup() {
    popupWrapper.classList.remove("active");
    document.documentElement.classList.remove("no-scroll");
    signUpCard.classList.remove("active");
    logInCard.classList.remove("active");
    resetPasswordCard.classList.remove("active");

    header.classList.remove("hidden");
}

loginBtn.on("click", () => {
    openPopup(logInCard);
});

signupBtn?.addEventListener("click", () => {
    openPopup(signUpCard);
});

burgerMenu?.addEventListener("click", () => {
    openPopup(logInCard);
});

signupLink?.addEventListener("click", () => {
    openPopup(signUpCard);
});

resetPassLink?.addEventListener("click", () => {
    openPopup(resetPasswordCard);
});

closeButtons?.forEach((button) => {
    button.addEventListener("click", () => {
        closePopup();
    });
});

popupWrapper?.addEventListener("click", (event) => {
    if (!signUpCard.contains(event.target) &&
        !logInCard.contains(event.target) &&
        !resetPasswordCard.contains(event.target)
    ) {
        closePopup();
    }
});

const showPasswordButtons = document.querySelectorAll(".show-password");
showPasswordButtons.forEach((button) => {
    button.addEventListener("click", function() {
        const passwordInput = $(this).siblings('[name="password"]')[0];
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            this.classList.add("open");
        } else {
            passwordInput.type = "password";
            this.classList.remove("open");
        }
    });
});

const enableSubmitButton = (form) => {
    if (!form) {
        return
    }

    const inputs = form.querySelectorAll(
        'input[type="email"], input[type="password"]'
    );
    const submitButton = form.querySelector(".submit.btn");

    const checkInputs = () => {
        const allFilled = Array.from(inputs).every(
            (input) => input.value.trim() !== ""
        );
        submitButton.disabled = !allFilled;
    };

    inputs.forEach((input) => {
        input.addEventListener("input", checkInputs);
    });

    checkInputs();
};

enableSubmitButton(document.querySelector(".signUP-card form"));
enableSubmitButton(document.querySelector(".logIN-card form"));
enableSubmitButton(document.querySelector(".resetPassword-card form"));

const inputs = document.querySelectorAll(".code-inputs input");

inputs.forEach((input, index) => {
    input.addEventListener("input", () => {
        if (input.value.length === 1 && index < inputs.length - 1) {
            inputs[index + 1].focus();
        }
    });

    input.addEventListener("keydown", (e) => {
        if (e.key === "Backspace" && index > 0 && input.value === "") {
            inputs[index - 1].focus();
        }
    });
});

//__________________________AJAX Setup_________________________//

$.ajaxSetup({
    beforeSend: (xhr) => xhr.setRequestHeader(
        'X-CSRF-TOKEN', 
        $('meta[name="csrf-token"]').attr('content')
    ) 
})

//__________________________ADVERTISING_________________________//

if (DS && DS?.ads?.data && DS?.ads?.settings) {
    const adPopup = {
        counters: {
            secs: 0,
            clicks: 0,
        },
        next: null,
        showing: false,
        get secsCount() {
            return this.counters.secs
        },
        set secsCount(count) {
            if (this.showing) {
                return
            }

            if (count >= parseInt(DS.ads.settings.seconds_between_popups)) {
                this.showing = true
                this.counters.secs = 0
                this.counters.clicks = 0
                this.show()
            } else {
                this.counters.secs = count
            }
        },
        get clicksCount() {
            return this.counters.clicks
        },
        set clicksCount(count) {
            if (this.showing) {
                return
            }

            if (count >= parseInt(DS.ads.settings.clicks_between_popups)) {
                this.showing = true
                this.counters.secs = 0
                this.counters.clicks = 0
                this.show()
            } else {
                this.counters.clicks = count
            }
        },
        show() {
            if (! this.next) {
                return
            }

            const popup = $('.advertising-wrapper')
            const img = $('.advertising-img')
            const link = $('.advertising-link')
    
            popup.data('id', this.next.id)
            img.attr('src', this.next.image.url)
            link.attr('href', this.next.link)

            adCloseTimer.start(DS.ads.settings.close_popup_seconds)

            popup.addClass('show')

            this.getNext()
        },
        hide() {
            this.showing = false
            $('.advertising-wrapper').removeClass('show')
        },
        getNext() {
            const min = 0
            const max = DS.ads.data.length - 1
            const rand = Math.floor(Math.random() * (max - min + 1)) + min
    
            this.next = DS.ads.data[rand]

            this.predownloadNextImage()
        },
        predownloadNextImage() {
            const image = new Image 
            image.src = this.next.image.url 
        },
        ini() {
            this.getNext()

            $('.advertising-wrapper').on('click', '.advertising-close-timer.enabled', () => {
                this.hide()
            })
        
            $('.users-item').on('click auxclick', () => {
                this.clicksCount += 1
            })
        
            setInterval(() => {
                this.secsCount += 1
            }, 1000)
        },
    }

    const adCloseTimer = {
        secs: 0,
        interval: null,
        start(secs) {
            const close = $('.advertising-close-timer')
            close.removeClass('enabled')
            close.addClass('disabled')

            const timer = $('.advertising-close-timer .timer')
            timer.text(secs)

            this.secs = secs

            this.interval = setInterval(() => {
                this.secs--

                timer.text(this.secs)

                if (this.secs <= 0) {
                    close.addClass('enabled')
                    close.removeClass('disabled')
                    clearInterval(this.interval)
                }
            }, 1000)
        }
    }

    adPopup.ini()
}

$('.advertising-link').on('auxclick click', function () {
    const id = $(this).closest('.advertising-wrapper').data('id')

    $.post(`/ads/${id}/click`)
})

$('.advertising-banner').on('auxclick click', function () {
    const id = $(this).data('id')

    $.post(`/ads/${id}/click`)
})

//__________________________Loader_________________________//

function addLoader(selector) {
    $(selector).append('<div class="loader"></div>')
}

function removeLoader(selector) {
    $(selector).find('.loader').remove()
}

//__________________________Verification Code_________________________//

$('.code-inputs input').on('input', () => {
    const code = []
    $('.code-inputs input').each((i, input) => {
        if (input.value) {
            code.push(input.value)
        }
    })

    if (code.length != 6) {
        return
    }

    if ($('.verification-wrapper').hasClass('sign-up-code')) {
        verifySignUpCode(code.join(''))
    }

    if ($('.verification-wrapper').hasClass('sign-in-code')) {
        verifySignInCode(code.join(''))
    }
})

const resendTimer = {
    secs: 0,
    interval: null,
    start(secs) {
        this.secs = secs
    
        this.interval = setInterval(() => {    
            --this.secs
    
            const formatted = (this.secs - (this.secs %= 60)) / 60 + (9 < this.secs ? ':' : ':0') + this.secs
            $('#countdown').text(formatted)

            if (this.secs <= 0) {
                clearInterval(this.interval)
            }
        }, 1000)
    },
}

$('.again').on('click', () => {
    if (resendTimer.secs > 0) {
        return
    }

    if ($('.verification-wrapper').hasClass('sign-up-code')) {
        resendSignUpCode()
    }

    if ($('.verification-wrapper').hasClass('sign-in-code')) {
        resendSignInCode()
    }
})

//__________________________Sign Up_________________________//

$('#sign-up').submit(function(e) {
    e.preventDefault()

    const form = $(this)
    const email = form.find('#email')
    const password = form.find('#password')
    email.closest('.input-group').removeClass('error')
    password.closest('.input-group').removeClass('error')

    addLoader('.signUP-card')

    $.post('/sign-up/send-code', form.serialize())
        .done(() => {
            const verifyPopup = $('.verification-wrapper')
            verifyPopup.find('.email').text(email.val())
            verifyPopup.addClass('sign-up-code')
            verifyPopup.addClass('active')
            $('.signUP-card').removeClass('active')
            resendTimer.start(60)
        }).fail(xhr => {
            if (xhr.status == 422) {
                const errors = xhr.responseJSON.errors
                if (errors.email) {
                    email.closest('.input-group').addClass('error')
                    email.next('.error-text').text(errors.email[0])
                }

                if (errors.password) {
                    password.closest('.input-group').addClass('error')
                    password.next('.error-text').text(errors.password[0])
                }
            } else {
                alert(xhr.responseJSON.message)
            }
        }).always(() => {
            removeLoader('.signUP-card')
        })
})

function verifySignUpCode(code) {
    addLoader('.verification-container')

    $.post('/sign-up/verify-code', { code })
        .done(() => {
            location.reload()
        }).fail(err => {
            alert(err.responseJSON.message)
        }).always(() => {
            removeLoader('.verification-container')
        })
}

function resendSignUpCode() {
    addLoader('.verification-container')

    $.post('/sign-up/resend-code')
        .done(() => {
            resendTimer.start(60)
        }).fail(err => {
            alert(err.responseJSON.message)
        }).always(() => {
            removeLoader('.verification-container')
        })
}

//__________________________Sign In_________________________//

$('#sign-in').submit(function(e) {
    e.preventDefault()

    const form = $(this)
    const email = form.find('#email')
    const password = form.find('#password')
    email.closest('.input-group').removeClass('error')
    password.closest('.input-group').removeClass('error')

    addLoader('.logIN-card')

    $.post('/sign-in/send-code', form.serialize())
        .done(() => {
            const verifyPopup = $('.verification-wrapper')
            verifyPopup.find('.email').text(email.val())
            verifyPopup.addClass('sign-in-code')
            verifyPopup.addClass('active')
            $('.logIN-card').removeClass('active')
            resendTimer.start(60)
        }).fail(xhr => {
            if (xhr.status == 401) {
                password.closest('.input-group').addClass('error')
                password.next('.error-text').text(xhr.responseJSON.message)
            } else if (xhr.status == 422) {
                const errors = xhr.responseJSON.errors
                if (errors.email) {
                    email.closest('.input-group').addClass('error')
                    email.next('.error-text').text(errors.email[0])
                }

                if (errors.password) {
                    password.closest('.input-group').addClass('error')
                    password.next('.error-text').text(errors.password[0])
                }
            } else {
                alert(xhr.responseJSON.message)
            }
        }).always(() => {
            removeLoader('.logIN-card')
        })
})

function verifySignInCode(code) {
    addLoader('.verification-container')

    $.post('/sign-in/verify-code', { code })
        .done(() => {
            location.reload()
        }).fail(err => {
            alert(err.responseJSON.message)
        }).always(() => {
            removeLoader('.verification-container')
        })
}

function resendSignInCode() {
    addLoader('.verification-container')

    $.post('/sign-in/resend-code')
        .done(() => {
            resendTimer.start(60)
        }).fail(err => {
            alert(err.responseJSON.message)
        }).always(() => {
            removeLoader('.verification-container')
        })
}

//__________________________Forgot Password_________________________//

$('#forgot-password').submit(function(e) {
    e.preventDefault()

    const form = $(this)
    const email = form.find('#reset-email')
    email.closest('.input-group').removeClass('error')

    addLoader('.resetPassword-card')

    $.post('/password/forgot', form.serialize())
        .done(() => {
            form[0].reset()
        }).fail(xhr => {
            if (xhr.status == 422) {
                const errors = xhr.responseJSON.errors
                if (errors.email) {
                    email.closest('.input-group').addClass('error')
                    email.next('.error-text').text(errors.email[0])
                }
            } else {
                alert(xhr.responseJSON.message)
            }
        }).always(() => {
            removeLoader('.resetPassword-card')
        })
})

//__________________________Favorites_________________________//

$('.likes').on('click', '.btn:not(.added)', function(e) {
    e.preventDefault()
    e.stopPropagation()

    $(this).addClass('added')
    const likes = $(this).closest('.likes')
        .find('.likes-count')
    likes.text(parseInt(likes.text()) + 1)

    const id = $(this).closest('.likes').data('id')

    $.post('/favorites/add', { favorite_id: id, }).fail(() => {
        $(this).removeClass('added')
        likes.text(parseInt(likes.text()) - 1)
    })
})

$('.likes').on('click', '.btn.added', function(e) {
    e.preventDefault()
    e.stopPropagation()

    $(this).removeClass('added')
    const likes = $(this).closest('.likes')
        .find('.likes-count')
    likes.text(parseInt(likes.text()) - 1)

    const id = $(this).closest('.likes').data('id')

    $.post('/favorites/remove', { favorite_id: id, }).fail(() => {
        $(this).addClass('added')
        likes.text(parseInt(likes.text()) + 1)
    })
})

//__________________________Filters_________________________//

$('#filters-form').submit(function() {
    $(this).find('input[name]')
        .filter((i, input) => !input.value)
        .prop('name', '')
})