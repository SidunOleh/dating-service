Fancybox.bind("[data-fancybox]", {});

//__________________________HEADER__________________________//

$(".burger-menu").click(function () {
  $(".header-menu").toggleClass("open");
});

$(".header-menu .close").click(function () {
  $(".header-menu").removeClass("open");
});

//__________________________USERS-CARD__________________________//

$(".user-image .arrow").on("click", function (event) {
  event.preventDefault();
  event.stopPropagation();
});

//__________________________SLIDERS__________________________//

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

//_____________________SIGN-UP_LOG-IN______________________//

const $popupWrapper = $(".popUp-wrapper");
const $header = $(".header");
const $cards = {
    signUp: $(".signUP-card"),
    logIn: $(".logIN-card"),
    resetPassword: $(".resetPassword-card"),
    resSuccesSend: $(".res-succes-send"),
    addNewPassCard: $(".addNew-pass-card"),
    passSucces: $(".pass-succes"),
};

function togglePopup(cardName, show) {
    const $card = $cards[cardName];
    $popupWrapper.toggleClass("active", show);
    $("html").toggleClass("no-scroll", show);
    $header.toggleClass("hidden", show && $(window).width() < 768);

    Object.values($cards).forEach(($c) => $c.removeClass("active"));
    if (show) $card.addClass("active");
    window.dispatchEvent(new Event('resize'))
}

$(".btn.login, .header-burger").on("click", () => togglePopup("logIn", true));
$(".btn.signup, .signup-link").on("click", () => togglePopup("signUp", true));
$(".reset-pass").on("click", () => togglePopup("resetPassword", true));
$(".close").on("click", () => togglePopup("", false));

// $popupWrapper.on("click", function (event) {
//   if (
//     !$(event.target).closest(".signUP-card, .logIN-card, .resetPassword-card")
//       .length
//   ) {
//     togglePopup("", false);
//   }
// });

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

$(".code-inputs input").each(function (index, input) {
    $(input)
    .on("input", function () {
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

//__________________________AJAX Setup_________________________//

$.ajaxSetup({beforeSend: xhr => xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content')),})

//__________________________ADVERTISING_________________________//

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
            return this.counters.secs
        },
        set secsCount(count) {
            if (this.showing) {
                return
            }

            if (count >= parseInt(DS.ads.settings.seconds_between_popups)) {
                this.showing = true
                clearInterval(this.interval)
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
                clearInterval(this.interval)
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
    
            img.attr('src', this.next.image.url)
            link.data('id', this.next.id)
            link.attr('href', this.next.link)

            adCloseTimer.start(DS.ads.settings.close_popup_seconds)

            popup.addClass('show')

            this.getNext()
        },
        hide() {
            this.counters.secs = 0
            this.counters.clicks = 0

            this.interval = setInterval(() => {
                this.secsCount += 1
            }, 1000)

            this.showing = false

            $('.advertising-wrapper').removeClass('show')
        },
        getNext() {
            if (! DS.ads.data.length) {
                return
            }

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
        
            $('.users-item.profile-item').bind('click auxclick', () => {
                this.clicksCount += 1
            })

            $('.advertising-link').bind('auxclick click', function () {
                $.post(`/ads/${$(this).data('id')}/click`)
            })
        
            this.interval = setInterval(() => {
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

$('.advertising-banner, .users-item.add').bind('auxclick click', function () {
    $.post(`/ads/${$(this).data('id')}/click`)
})

//__________________________Loader_________________________//

function addLoader(selector) {
    $(selector).append('<div class="loading"></div>')
}

function removeLoader(selector) {
    $(selector).find('.loading').remove()
}

//__________________________Verification Code_________________________//

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

$('.code-inputs input').bind('paste', function (e) {
    e.preventDefault()

    const inputs = $('.code-inputs input')

    let code = (e.originalEvent.clipboardData || window.clipboardData).getData('text')
    code = code.split('')
    code.forEach((number, i) => $(inputs[i]).val(number))
})

$('.verification-wrapper .code-inputs input').bind('input paste', () => {
    const code = []
    $('.code-inputs input').each((i, input) => {
        if (input.value) {
            code.push(input.value)
        }
    })

    if (code.length != 6) {
        return
    }

    if ($('.verification-wrapper').data('action') == 'sign-up') {
        verifySignUpCode(code.join(''))
    }

    if ($('.verification-wrapper').data('action') == 'sign-in') {
        verifySignInCode(code.join(''))
    }
})

$('.verification-wrapper .again').on('click', () => {
    if (resendTimer.secs > 0) {
        return
    }

    if ($('.verification-wrapper').data('action') == 'sign-up') {
        resendSignUpCode()
    }

    if ($('.verification-wrapper').data('action') == 'sign-in') {
        resendSignInCode()
    }
})

function openVerifyPopup(action, email) {
    const verifyPopup = $('.verification-wrapper')
    verifyPopup.data('action', action)
    verifyPopup.find('.email').text(email)
    verifyPopup.addClass('active')
}

//__________________________Sign Up_________________________//

$('#sign-up').submit(async function(e) {
    e.preventDefault()
    
    addLoader('.signUP-card')

    const form = $(this)

    const email = form.find('#email')
    email.closest('.input-group').removeClass('error')
    const password = form.find('#password')
    password.closest('.input-group').removeClass('error')
    const error = form.closest('.signUP-card').find('.text-error')
    error.removeClass('show')

    const data = form.serialize() + `&recaptcha=${await getReCaptchaV3('signin')}`

    $.post('/sign-up/send-code', data)
        .done(() => {
            togglePopup('signUp', false)
            
            openVerifyPopup('sign-up', email.val())
                        
            resendTimer.start(60)
        }).fail(xhr => {
            if (xhr.status == 422) {
                const errors = xhr.responseJSON.errors

                for (const field in errors) {
                    if (field == 'email') {
                        email.closest('.input-group').addClass('error')
                        email.next('.error-text').text(errors.email[0])
                    } else if (field == 'password') {
                        password.closest('.input-group').addClass('error')
                        password.next('.error-text').text(errors.password[0])
                    } else {
                        error.text(errors[field][0])
                        error.addClass('show')
                    }
                }
            } else {
                error.text(xhr.responseJSON.message)
                error.addClass('show')
            }
        }).always(() => {
            removeLoader('.signUP-card')
        })
})

async function verifySignUpCode(code) {
    addLoader('.verification-container')

    const codeForm = $('.code-inputs')
    codeForm.removeClass('error')
    const codeError = codeForm.find('.error-text')
    codeError.text('')

    const data = `code=${code}&recaptcha=${await getReCaptchaV3('verify_signup')}`

    $.post('/sign-up/verify-code', data)
        .done(() => {
            location.href = '/my-profile'
        }).fail(err => {
            codeForm.addClass('error')
            codeError.text(err.responseJSON.message)
        }).always(() => {
            removeLoader('.verification-container')
        })
}

async function resendSignUpCode() {
    addLoader('.verification-container')

    const codeForm = $('.code-inputs')
    codeForm.removeClass('error')
    const codeError = codeForm.find('.error-text')
    codeError.text('')

    const data = `recaptcha=${await getReCaptchaV3('resend_signup')}`

    $.post('/sign-up/resend-code', data)
        .done(() => {
            resendTimer.start(60)
        }).fail(err => {
            codeForm.addClass('error')
            codeError.text(err.responseJSON.message)
        }).always(() => {
            removeLoader('.verification-container')
        })
}

//__________________________Sign In_________________________//

$('#sign-in').submit(async function(e) {
    e.preventDefault()

    addLoader('.logIN-card')

    const form = $(this)

    const email = form.find('#email')
    email.closest('.input-group').removeClass('error')
    const password = form.find('#password')
    password.closest('.input-group').removeClass('error')
    const error = form.closest('.logIN-card').find('.text-error')
    error.removeClass('show')

    const data = form.serialize() + `&recaptcha=${await getReCaptchaV3('signin')}`

    $.post('/sign-in/send-code', data)
        .done(() => {
            togglePopup('logIn', false)

            openVerifyPopup('sign-in', email.val())
                        
            resendTimer.start(60)
        }).fail(xhr => {
            if (xhr.status == 401) {
                password.closest('.input-group').addClass('error')
                password.next('.error-text').text(xhr.responseJSON.message)
            } else if (xhr.status == 422) {
                const errors = xhr.responseJSON.errors

                for (const field in errors) {
                    if (field == 'email') {
                        email.closest('.input-group').addClass('error')
                        email.next('.error-text').text(errors.email[0])
                    } else if (field == 'password') {
                        password.closest('.input-group').addClass('error')
                        password.next('.error-text').text(errors.password[0])
                    } else {
                        error.text(errors[field][0])
                        error.addClass('show')
                    }
                }
            } else {
                error.text(xhr.responseJSON.message)
                error.addClass('show')
            }
        }).always(() => {
            removeLoader('.logIN-card')
        })
})

async function verifySignInCode(code) {
    addLoader('.verification-container')

    const codeForm = $('.code-inputs')
    codeForm.removeClass('error')
    const codeError = codeForm.find('.error-text')
    codeError.text('')

    const data = `code=${code}&recaptcha=${await getReCaptchaV3('verify_signin')}`

    $.post('/sign-in/verify-code', data)
        .done(() => {
            location.href = '/my-profile'
        }).fail(err => {
            codeForm.addClass('error')
            codeError.text(err.responseJSON.message)
        }).always(() => {
            removeLoader('.verification-container')
        })
}

async function resendSignInCode() {
    addLoader('.verification-container')

    const codeForm = $('.code-inputs')
    codeForm.removeClass('error')
    const codeError = codeForm.find('.error-text')
    codeError.text('')

    const data = `recaptcha=${await getReCaptchaV3('resend_signin')}`

    $.post('/sign-in/resend-code', data)
        .done(() => {
            resendTimer.start(60)
        }).fail(err => {
            codeForm.addClass('error')
            codeError.text(err.responseJSON.message)
        }).always(() => {
            removeLoader('.verification-container')
        })
}

//__________________________Forgot Password_________________________//

$('#forgot-password').submit(async function(e) {
    e.preventDefault()

    addLoader('.resetPassword-card')

    const form = $(this)

    const email = form.find('#reset-email')
    email.closest('.input-group').removeClass('error')
    const error = form.closest('.resetPassword-card').find('.text-error')
    error.removeClass('show')

    const data = form.serialize() + `&recaptcha=${await getReCaptchaV3('forgot')}`

    $.post('/password/forgot', data)
        .done(() => {
            $('.res-succes-send').find('.mail').text(email.val())

            togglePopup('resetPassword', false)
            togglePopup('resSuccesSend', true)

            form[0].reset()
        }).fail(xhr => {
            if (xhr.status == 422) {
                const errors = xhr.responseJSON.errors

                for (const field in errors) {
                    if (field == 'email') {
                        email.closest('.input-group').addClass('error')
                        email.next('.error-text').text(errors.email[0])
                    } else {
                        error.text(errors[field][0])
                        error.addClass('show')
                    }
                }
            } else {
                error.addClass('show')
                error.text(xhr.responseJSON.message)
            }
        }).always(() => {
            removeLoader('.resetPassword-card')
        })
})

$('.res-succes-send .btn').click(() => {
    togglePopup('resSuccesSend', false)
})

//__________________________Reset password_________________________//

$('#new-password-form').submit(async function (e) {
    e.preventDefault()

    addLoader('.addNew-pass-card')

    const form = $(this)

    const password = form.find('#new-password')
    password.closest('.input-group').removeClass('error')
    const error = form.closest('.addNew-pass-card').find('.text-error')
    error.removeClass('show')

    const data = form.serialize() + `&recaptcha=${await getReCaptchaV3('forgot')}`

    $.post('/password/reset', data)
        .done(() => {
            togglePopup('addNewPassCard', false)
            togglePopup('passSucces', true)

            form[0].reset()
        }).fail(xhr => {
            if (xhr.status == 422) {
                const errors = xhr.responseJSON.errors

                for (const field in errors) {
                    if (field == 'password') {
                        password.closest('.input-group').addClass('error')
                        password.next('.error-text').text(errors.password[0])
                    } else {
                        error.text(errors[field][0])
                        error.addClass('show')
                    }
                }
            } else {
                error.addClass('show')
                error.text(xhr.responseJSON.message)
            }
        }).always(() => {
            removeLoader('.addNew-pass-card')
        })
})

//__________________________Favorites_________________________//

$('.likes').on('click', '.btn:not(.active)', function(e) {
    e.preventDefault()
    e.stopPropagation()

    $(this).addClass('active')
    const likes = $(this)
        .closest('.likes')
        .find('.likes-count')
    likes.text(parseInt(likes.text()) + 1)

    const id = $(this).closest('.likes').data('id')

    $.post('/favorites/add', { favorite_id: id, })
})

$('.likes').on('click', '.btn.active', function(e) {
    e.preventDefault()
    e.stopPropagation()

    $(this).removeClass('active')
    const likes = $(this)
        .closest('.likes')
        .find('.likes-count')
    likes.text(parseInt(likes.text()) - 1)

    const id = $(this).closest('.likes').data('id')

    $.post('/favorites/remove', { favorite_id: id, })
})

//__________________________Filters_________________________//

$('#filters-form').submit(function() {
    $(this).find('input[name]')
        .filter((i, input) => !input.value)
        .prop('name', '')
})

//__________________________Change options_________________________//

$('#vote-battle, #account-visibility').bind('change', function () {
    const name = $(this).attr('name')
    const value = $(this).prop('checked')

    $.ajax({
        type: 'PATCH',
        url: '/my-profile/switch-option', 
        data: JSON.stringify({name, value}),
        contentType: 'application/json',
    })
})

//__________________________Delete profile_________________________//

$('.delete-acc').click(() => {
    $('#delete-popup').addClass('active')
})

$('#delete-popup #close-popup-btn').click(() => {
    $('#delete-popup').removeClass('active')
})

$('#delete-popup #confirm-delete:not(.load)').click(function () {
    $(this).addClass('load')

    $.ajax({
        type: 'DELETE',
        url: '/my-profile',
    }).then(() => {
        location.href = '/my-profile/create'
    }).catch(jqXHR => {
        alert(jqXHR.responseJSON.message)
        
        $(this).removeClass('load')
    })
})

//__________________________Roulette_________________________//

function initializeBattle($battle) {
    let nextPair = null

    function getNextPair() {
        $.get('/roulette/get-pair').then(res => {
            if (! res.pair) {
                return
            }

            nextPair = res.pair

            const predownloadPhoto = url => {
                const image = new Image 
                image.src = url
            }

            predownloadPhoto(nextPair[0].gallery[0].url)
            predownloadPhoto(nextPair[1].gallery[0].url)
        })
    }

    getNextPair()
    
    function renderNextPair() {
        if (! nextPair) {
            return
        }

        const html = creator => {
            return `
            <div class="photo-container photo" data-id="${creator.id}">
                <img src="${creator.gallery[0].url}">
                <div class="info">
                    ${creator.name.length > 5 ? creator.name.substr(0, 5) + '...' : creator.name}, ${creator.age}
                </div>
            </div>`
        }

        $battle.find('.photo:first').replaceWith(html(nextPair[0]))
        $battle.find('.photo:last').replaceWith(html(nextPair[1]))
    }

    function vote(id) {
        $.post(`/roulette/vote/${id}`)
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
      startProgressAnimation($circle, 5000);
      setTimeout(() => activateRepeatButton($this), 5000);
    });

    $battle.on("click", ".photo", function () {
      const $selectedPhoto = $(this);
      
      if ($selectedPhoto.hasClass('selected')) {
        window.open(`/profile/${$selectedPhoto.data('id')}`, '_blank')
      }

      if (!hasSelected) {
        const $blurredPhoto = $battle.find(".photo").not($selectedPhoto);
        selectPhoto($selectedPhoto, $blurredPhoto);
        hasSelected = true;
        vote($selectedPhoto.data('id'))
      } 
    });

    $battle.on("click", ".repeat.active", function () {
      setTimeout(() => {
          renderNextPair()
          hasSelected = false
          getNextPair()
      }, 500)
      
      const $this = $(this);
      const $loader = $battle.find(".loader");

      $this.removeClass("active");
      $loader.addClass("open");

      setTimeout(() => {
        $loader.removeClass("open");
      }, 1500);

      restartProgressAnimation($circle, 5000);
      setTimeout(() => activateRepeatButton($this), 6500);
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