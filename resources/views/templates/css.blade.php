<style>
    :root {
    --f-spinner-width: 36px;
    --f-spinner-height: 36px;
    --f-spinner-color-1: rgba(0, 0, 0, 0.1);
    --f-spinner-color-2: rgba(17, 24, 28, 0.8);
    --f-spinner-stroke: 2.75
}

.f-spinner {
    margin: auto;
    padding: 0;
    width: var(--f-spinner-width);
    height: var(--f-spinner-height)
}

.f-spinner svg {
    width: 100%;
    height: 100%;
    vertical-align: top;
    animation: f-spinner-rotate 2s linear infinite
}

.f-spinner svg * {
    stroke-width: var(--f-spinner-stroke);
    fill: none
}

.f-spinner svg *:first-child {
    stroke: var(--f-spinner-color-1)
}

.f-spinner svg *:last-child {
    stroke: var(--f-spinner-color-2);
    animation: f-spinner-dash 2s ease-in-out infinite
}

@keyframes f-spinner-rotate {
    100% {
        transform: rotate(360deg)
    }
}

@keyframes f-spinner-dash {
    0% {
        stroke-dasharray: 1, 150;
        stroke-dashoffset: 0
    }
    50% {
        stroke-dasharray: 90, 150;
        stroke-dashoffset: -35
    }
    100% {
        stroke-dasharray: 90, 150;
        stroke-dashoffset: -124
    }
}

.f-throwOutUp {
    animation: var(--f-throw-out-duration, 0.175s) ease-out both f-throwOutUp
}

.f-throwOutDown {
    animation: var(--f-throw-out-duration, 0.175s) ease-out both f-throwOutDown
}

@keyframes f-throwOutUp {
    to {
        transform: translate3d(0, calc(var(--f-throw-out-distance, 150px) * -1), 0);
        opacity: 0
    }
}

@keyframes f-throwOutDown {
    to {
        transform: translate3d(0, var(--f-throw-out-distance, 150px), 0);
        opacity: 0
    }
}

.f-zoomInUp {
    animation: var(--f-transition-duration, 0.2s) ease .1s both f-zoomInUp
}

.f-zoomOutDown {
    animation: var(--f-transition-duration, 0.2s) ease both f-zoomOutDown
}

@keyframes f-zoomInUp {
    from {
        transform: scale(0.975) translate3d(0, 16px, 0);
        opacity: 0
    }
    to {
        transform: scale(1) translate3d(0, 0, 0);
        opacity: 1
    }
}

@keyframes f-zoomOutDown {
    to {
        transform: scale(0.975) translate3d(0, 16px, 0);
        opacity: 0
    }
}

.f-fadeIn {
    animation: var(--f-transition-duration, 0.2s) var(--f-transition-easing, ease) var(--f-transition-delay, 0s) both f-fadeIn;
    z-index: 2
}

.f-fadeOut {
    animation: var(--f-transition-duration, 0.2s) var(--f-transition-easing, ease) var(--f-transition-delay, 0s) both f-fadeOut;
    z-index: 1
}

@keyframes f-fadeIn {
    0% {
        opacity: 0
    }
    100% {
        opacity: 1
    }
}

@keyframes f-fadeOut {
    100% {
        opacity: 0
    }
}

.f-fadeFastIn {
    animation: var(--f-transition-duration, 0.2s) ease-out both f-fadeFastIn;
    z-index: 2
}

.f-fadeFastOut {
    animation: var(--f-transition-duration, 0.1s) ease-out both f-fadeFastOut;
    z-index: 2
}

@keyframes f-fadeFastIn {
    0% {
        opacity: .75
    }
    100% {
        opacity: 1
    }
}

@keyframes f-fadeFastOut {
    100% {
        opacity: 0
    }
}

.f-fadeSlowIn {
    animation: var(--f-transition-duration, 0.5s) ease both f-fadeSlowIn;
    z-index: 2
}

.f-fadeSlowOut {
    animation: var(--f-transition-duration, 0.5s) ease both f-fadeSlowOut;
    z-index: 1
}

@keyframes f-fadeSlowIn {
    0% {
        opacity: 0
    }
    100% {
        opacity: 1
    }
}

@keyframes f-fadeSlowOut {
    100% {
        opacity: 0
    }
}

.f-crossfadeIn {
    animation: var(--f-transition-duration, 0.2s) ease-out both f-crossfadeIn;
    z-index: 2
}

.f-crossfadeOut {
    animation: calc(var(--f-transition-duration, 0.2s)*.5) linear .1s both f-crossfadeOut;
    z-index: 1
}

@keyframes f-crossfadeIn {
    0% {
        opacity: 0
    }
    100% {
        opacity: 1
    }
}

@keyframes f-crossfadeOut {
    100% {
        opacity: 0
    }
}

.f-slideIn.from-next {
    animation: var(--f-transition-duration, 0.85s) cubic-bezier(0.16, 1, 0.3, 1) f-slideInNext
}

.f-slideIn.from-prev {
    animation: var(--f-transition-duration, 0.85s) cubic-bezier(0.16, 1, 0.3, 1) f-slideInPrev
}

.f-slideOut.to-next {
    animation: var(--f-transition-duration, 0.85s) cubic-bezier(0.16, 1, 0.3, 1) f-slideOutNext
}

.f-slideOut.to-prev {
    animation: var(--f-transition-duration, 0.85s) cubic-bezier(0.16, 1, 0.3, 1) f-slideOutPrev
}

@keyframes f-slideInPrev {
    0% {
        transform: translateX(100%)
    }
    100% {
        transform: translate3d(0, 0, 0)
    }
}

@keyframes f-slideInNext {
    0% {
        transform: translateX(-100%)
    }
    100% {
        transform: translate3d(0, 0, 0)
    }
}

@keyframes f-slideOutNext {
    100% {
        transform: translateX(-100%)
    }
}

@keyframes f-slideOutPrev {
    100% {
        transform: translateX(100%)
    }
}

.f-classicIn.from-next {
    animation: var(--f-transition-duration, 0.85s) cubic-bezier(0.16, 1, 0.3, 1) f-classicInNext;
    z-index: 2
}

.f-classicIn.from-prev {
    animation: var(--f-transition-duration, 0.85s) cubic-bezier(0.16, 1, 0.3, 1) f-classicInPrev;
    z-index: 2
}

.f-classicOut.to-next {
    animation: var(--f-transition-duration, 0.85s) cubic-bezier(0.16, 1, 0.3, 1) f-classicOutNext;
    z-index: 1
}

.f-classicOut.to-prev {
    animation: var(--f-transition-duration, 0.85s) cubic-bezier(0.16, 1, 0.3, 1) f-classicOutPrev;
    z-index: 1
}

@keyframes f-classicInNext {
    0% {
        transform: translateX(-75px);
        opacity: 0
    }
    100% {
        transform: translate3d(0, 0, 0);
        opacity: 1
    }
}

@keyframes f-classicInPrev {
    0% {
        transform: translateX(75px);
        opacity: 0
    }
    100% {
        transform: translate3d(0, 0, 0);
        opacity: 1
    }
}

@keyframes f-classicOutNext {
    100% {
        transform: translateX(-75px);
        opacity: 0
    }
}

@keyframes f-classicOutPrev {
    100% {
        transform: translateX(75px);
        opacity: 0
    }
}

:root {
    --f-button-width: 40px;
    --f-button-height: 40px;
    --f-button-border: 0;
    --f-button-border-radius: 0;
    --f-button-color: #374151;
    --f-button-bg: #f8f8f8;
    --f-button-hover-bg: #e0e0e0;
    --f-button-active-bg: #d0d0d0;
    --f-button-shadow: none;
    --f-button-transition: all 0.15s ease;
    --f-button-transform: none;
    --f-button-svg-width: 20px;
    --f-button-svg-height: 20px;
    --f-button-svg-stroke-width: 1.5;
    --f-button-svg-fill: none;
    --f-button-svg-filter: none;
    --f-button-svg-disabled-opacity: 0.65
}

.f-button {
    display: flex;
    justify-content: center;
    align-items: center;
    box-sizing: content-box;
    position: relative;
    margin: 0;
    padding: 0;
    width: var(--f-button-width);
    height: var(--f-button-height);
    border: var(--f-button-border);
    border-radius: var(--f-button-border-radius);
    color: var(--f-button-color);
    background: var(--f-button-bg);
    box-shadow: var(--f-button-shadow);
    pointer-events: all;
    cursor: pointer;
    transition: var(--f-button-transition)
}

@media(hover: hover) {
    .f-button:hover:not([disabled]) {
        color: var(--f-button-hover-color);
        background-color: var(--f-button-hover-bg)
    }
}

.f-button:active:not([disabled]) {
    background-color: var(--f-button-active-bg)
}

.f-button:focus:not(:focus-visible) {
    outline: none
}

.f-button:focus-visible {
    outline: none;
    box-shadow: inset 0 0 0 var(--f-button-outline, 2px) var(--f-button-outline-color, var(--f-button-color))
}

.f-button svg {
    width: var(--f-button-svg-width);
    height: var(--f-button-svg-height);
    fill: var(--f-button-svg-fill);
    stroke: currentColor;
    stroke-width: var(--f-button-svg-stroke-width);
    stroke-linecap: round;
    stroke-linejoin: round;
    transition: opacity .15s ease;
    transform: var(--f-button-transform);
    filter: var(--f-button-svg-filter);
    pointer-events: none
}

.f-button[disabled] {
    cursor: default
}

.f-button[disabled] svg {
    opacity: var(--f-button-svg-disabled-opacity)
}

.f-carousel__nav .f-button.is-prev,
.f-carousel__nav .f-button.is-next,
.fancybox__nav .f-button.is-prev,
.fancybox__nav .f-button.is-next {
    position: absolute;
    z-index: 1
}

.is-horizontal .f-carousel__nav .f-button.is-prev,
.is-horizontal .f-carousel__nav .f-button.is-next,
.is-horizontal .fancybox__nav .f-button.is-prev,
.is-horizontal .fancybox__nav .f-button.is-next {
    top: 50%;
    transform: translateY(-50%)
}

.is-horizontal .f-carousel__nav .f-button.is-prev,
.is-horizontal .fancybox__nav .f-button.is-prev {
    left: var(--f-button-prev-pos)
}

.is-horizontal .f-carousel__nav .f-button.is-next,
.is-horizontal .fancybox__nav .f-button.is-next {
    right: var(--f-button-next-pos)
}

.is-horizontal.is-rtl .f-carousel__nav .f-button.is-prev,
.is-horizontal.is-rtl .fancybox__nav .f-button.is-prev {
    left: auto;
    right: var(--f-button-next-pos)
}

.is-horizontal.is-rtl .f-carousel__nav .f-button.is-next,
.is-horizontal.is-rtl .fancybox__nav .f-button.is-next {
    right: auto;
    left: var(--f-button-prev-pos)
}

.is-vertical .f-carousel__nav .f-button.is-prev,
.is-vertical .f-carousel__nav .f-button.is-next,
.is-vertical .fancybox__nav .f-button.is-prev,
.is-vertical .fancybox__nav .f-button.is-next {
    top: auto;
    left: 50%;
    transform: translateX(-50%)
}

.is-vertical .f-carousel__nav .f-button.is-prev,
.is-vertical .fancybox__nav .f-button.is-prev {
    top: var(--f-button-next-pos)
}

.is-vertical .f-carousel__nav .f-button.is-next,
.is-vertical .fancybox__nav .f-button.is-next {
    bottom: var(--f-button-next-pos)
}

.is-vertical .f-carousel__nav .f-button.is-prev svg,
.is-vertical .f-carousel__nav .f-button.is-next svg,
.is-vertical .fancybox__nav .f-button.is-prev svg,
.is-vertical .fancybox__nav .f-button.is-next svg {
    transform: rotate(90deg)
}

.f-carousel__nav .f-button:disabled,
.fancybox__nav .f-button:disabled {
    pointer-events: none
}

html.with-fancybox {
    width: auto;
    overflow: visible;
    scroll-behavior: auto
}

html.with-fancybox body {
    touch-action: none
}

html.with-fancybox body.hide-scrollbar {
    width: auto;
    margin-right: calc(var(--fancybox-body-margin, 0px) + var(--fancybox-scrollbar-compensate, 0px));
    overflow: hidden !important;
    overscroll-behavior-y: none
}

.fancybox__container {
    --fancybox-color: #dbdbdb;
    --fancybox-hover-color: #fff;
    --fancybox-bg: rgba(24, 24, 27, 0.98);
    --fancybox-slide-gap: 10px;
    --f-spinner-width: 50px;
    --f-spinner-height: 50px;
    --f-spinner-color-1: rgba(255, 255, 255, 0.1);
    --f-spinner-color-2: #bbb;
    --f-spinner-stroke: 3.65;
    position: fixed;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    direction: ltr;
    display: flex;
    flex-direction: column;
    box-sizing: border-box;
    margin: 0;
    padding: 0;
    color: #f8f8f8;
    -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
    overflow: visible;
    z-index: var(--fancybox-zIndex, 1050);
    outline: none;
    transform-origin: top left;
    -webkit-text-size-adjust: 100%;
    -moz-text-size-adjust: none;
    -ms-text-size-adjust: 100%;
    text-size-adjust: 100%;
    overscroll-behavior-y: contain
}

.fancybox__container *,
.fancybox__container *::before,
.fancybox__container *::after {
    box-sizing: inherit
}

.fancybox__container::backdrop {
    background-color: rgba(0, 0, 0, 0)
}

.fancybox__backdrop {
    position: fixed;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    z-index: -1;
    background: var(--fancybox-bg);
    opacity: var(--fancybox-opacity, 1);
    will-change: opacity
}

.fancybox__carousel {
    position: relative;
    box-sizing: border-box;
    flex: 1;
    min-height: 0;
    z-index: 10;
    overflow-y: visible;
    overflow-x: clip
}

.fancybox__viewport {
    width: 100%;
    height: 100%
}

.fancybox__viewport.is-draggable {
    cursor: move;
    cursor: grab
}

.fancybox__viewport.is-dragging {
    cursor: move;
    cursor: grabbing
}

.fancybox__track {
    display: flex;
    margin: 0 auto;
    height: 100%
}

.fancybox__slide {
    flex: 0 0 auto;
    position: relative;
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 100%;
    height: 100%;
    margin: 0 var(--fancybox-slide-gap) 0 0;
    padding: 4px;
    overflow: auto;
    overscroll-behavior: contain;
    transform: translate3d(0, 0, 0);
    backface-visibility: hidden
}

.fancybox__container:not(.is-compact) .fancybox__slide.has-close-btn {
    padding-top: 40px
}

.fancybox__slide.has-iframe,
.fancybox__slide.has-video,
.fancybox__slide.has-html5video {
    overflow: hidden
}

.fancybox__slide.has-image {
    overflow: hidden
}

.fancybox__slide.has-image.is-animating,
.fancybox__slide.has-image.is-selected {
    overflow: visible
}

.fancybox__slide::before,
.fancybox__slide::after {
    content: "";
    flex: 0 0 0;
    margin: auto
}

.fancybox__backdrop:empty,
.fancybox__viewport:empty,
.fancybox__track:empty,
.fancybox__slide:empty {
    display: block
}

.fancybox__content {
    align-self: center;
    display: flex;
    flex-direction: column;
    position: relative;
    margin: 0;
    padding: 2rem;
    max-width: 100%;
    color: var(--fancybox-content-color, #374151);
    background: var(--fancybox-content-bg, #fff);
    cursor: default;
    border-radius: 0;
    z-index: 20
}

.is-loading .fancybox__content {
    opacity: 0
}

.is-draggable .fancybox__content {
    cursor: move;
    cursor: grab
}

.can-zoom_in .fancybox__content {
    cursor: zoom-in
}

.can-zoom_out .fancybox__content {
    cursor: zoom-out
}

.is-dragging .fancybox__content {
    cursor: move;
    cursor: grabbing
}

.fancybox__content [data-selectable],
.fancybox__content [contenteditable] {
    cursor: auto
}

.fancybox__slide.has-image>.fancybox__content {
    padding: 0;
    background: rgba(0, 0, 0, 0);
    min-height: 1px;
    background-repeat: no-repeat;
    background-size: contain;
    background-position: center center;
    transition: none;
    transform: translate3d(0, 0, 0);
    backface-visibility: hidden
}

.fancybox__slide.has-image>.fancybox__content>picture>img {
    width: 100%;
    height: auto;
    max-height: 100%
}

.is-animating .fancybox__content,
.is-dragging .fancybox__content {
    will-change: transform, width, height
}

.fancybox-image {
    margin: auto;
    display: block;
    width: 100%;
    height: 100%;
    min-height: 0;
    object-fit: contain;
    user-select: none;
    filter: blur(0px)
}

.fancybox__caption {
    align-self: center;
    max-width: 100%;
    flex-shrink: 0;
    margin: 0;
    padding: 14px 0 4px 0;
    overflow-wrap: anywhere;
    line-height: 1.375;
    color: var(--fancybox-color, currentColor);
    opacity: var(--fancybox-opacity, 1);
    cursor: auto;
    visibility: visible
}

.is-loading .fancybox__caption,
.is-closing .fancybox__caption {
    opacity: 0;
    visibility: hidden
}

.is-compact .fancybox__caption {
    padding-bottom: 0
}

.f-button.is-close-btn {
    --f-button-svg-stroke-width: 2;
    position: absolute;
    top: 0;
    right: 8px;
    z-index: 40
}

.fancybox__content>.f-button.is-close-btn {
    --f-button-width: 34px;
    --f-button-height: 34px;
    --f-button-border-radius: 4px;
    --f-button-color: var(--fancybox-color, #fff);
    --f-button-hover-color: var(--fancybox-color, #fff);
    --f-button-bg: transparent;
    --f-button-hover-bg: transparent;
    --f-button-active-bg: transparent;
    --f-button-svg-width: 22px;
    --f-button-svg-height: 22px;
    position: absolute;
    top: -38px;
    right: 0;
    opacity: .75
}

.is-loading .fancybox__content>.f-button.is-close-btn {
    visibility: hidden
}

.is-zooming-out .fancybox__content>.f-button.is-close-btn {
    visibility: hidden
}

.fancybox__content>.f-button.is-close-btn:hover {
    opacity: 1
}

.fancybox__footer {
    padding: 0;
    margin: 0;
    position: relative
}

.fancybox__footer .fancybox__caption {
    width: 100%;
    padding: 24px;
    opacity: var(--fancybox-opacity, 1);
    transition: all .25s ease
}

.is-compact .fancybox__footer {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    z-index: 20;
    background: rgba(24, 24, 27, .5)
}

.is-compact .fancybox__footer .fancybox__caption {
    padding: 12px
}

.is-compact .fancybox__content>.f-button.is-close-btn {
    --f-button-border-radius: 50%;
    --f-button-color: #fff;
    --f-button-hover-color: #fff;
    --f-button-outline-color: #000;
    --f-button-bg: rgba(0, 0, 0, 0.6);
    --f-button-active-bg: rgba(0, 0, 0, 0.6);
    --f-button-hover-bg: rgba(0, 0, 0, 0.6);
    --f-button-svg-width: 18px;
    --f-button-svg-height: 18px;
    --f-button-svg-filter: none;
    top: 5px;
    right: 5px
}

.fancybox__nav {
    --f-button-width: 50px;
    --f-button-height: 50px;
    --f-button-border: 0;
    --f-button-border-radius: 50%;
    --f-button-color: var(--fancybox-color);
    --f-button-hover-color: var(--fancybox-hover-color);
    --f-button-bg: transparent;
    --f-button-hover-bg: rgba(24, 24, 27, 0.3);
    --f-button-active-bg: rgba(24, 24, 27, 0.5);
    --f-button-shadow: none;
    --f-button-transition: all 0.15s ease;
    --f-button-transform: none;
    --f-button-svg-width: 26px;
    --f-button-svg-height: 26px;
    --f-button-svg-stroke-width: 2.5;
    --f-button-svg-fill: none;
    --f-button-svg-filter: drop-shadow(1px 1px 1px rgba(24, 24, 27, 0.5));
    --f-button-svg-disabled-opacity: 0.65;
    --f-button-next-pos: 1rem;
    --f-button-prev-pos: 1rem;
    opacity: var(--fancybox-opacity, 1)
}

.fancybox__nav .f-button:before {
    position: absolute;
    content: "";
    top: -30px;
    right: -20px;
    left: -20px;
    bottom: -30px;
    z-index: 1
}

.is-idle .fancybox__nav {
    animation: .15s ease-out both f-fadeOut
}

.is-idle.is-compact .fancybox__footer {
    pointer-events: none;
    animation: .15s ease-out both f-fadeOut
}

.fancybox__slide>.f-spinner {
    position: absolute;
    top: 50%;
    left: 50%;
    margin: var(--f-spinner-top, calc(var(--f-spinner-width) * -0.5)) 0 0 var(--f-spinner-left, calc(var(--f-spinner-height) * -0.5));
    z-index: 30;
    cursor: pointer
}

.fancybox-protected {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 40;
    user-select: none
}

.fancybox-ghost {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    min-height: 0;
    object-fit: contain;
    z-index: 40;
    user-select: none;
    pointer-events: none
}

.fancybox-focus-guard {
    outline: none;
    opacity: 0;
    position: fixed;
    pointer-events: none
}

.fancybox__container:not([aria-hidden]) {
    opacity: 0
}

.fancybox__container.is-animated[aria-hidden=false]>*:not(.fancybox__backdrop, .fancybox__carousel),
.fancybox__container.is-animated[aria-hidden=false] .fancybox__carousel>*:not(.fancybox__viewport),
.fancybox__container.is-animated[aria-hidden=false] .fancybox__slide>*:not(.fancybox__content) {
    animation: var(--f-interface-enter-duration, 0.25s) ease .1s backwards f-fadeIn
}

.fancybox__container.is-animated[aria-hidden=false] .fancybox__backdrop {
    animation: var(--f-backdrop-enter-duration, 0.35s) ease backwards f-fadeIn
}

.fancybox__container.is-animated[aria-hidden=true]>*:not(.fancybox__backdrop, .fancybox__carousel),
.fancybox__container.is-animated[aria-hidden=true] .fancybox__carousel>*:not(.fancybox__viewport),
.fancybox__container.is-animated[aria-hidden=true] .fancybox__slide>*:not(.fancybox__content) {
    animation: var(--f-interface-exit-duration, 0.15s) ease forwards f-fadeOut
}

.fancybox__container.is-animated[aria-hidden=true] .fancybox__backdrop {
    animation: var(--f-backdrop-exit-duration, 0.35s) ease forwards f-fadeOut
}

.has-iframe .fancybox__content,
.has-map .fancybox__content,
.has-pdf .fancybox__content,
.has-youtube .fancybox__content,
.has-vimeo .fancybox__content,
.has-html5video .fancybox__content {
    max-width: 100%;
    flex-shrink: 1;
    min-height: 1px;
    overflow: visible
}

.has-iframe .fancybox__content,
.has-map .fancybox__content,
.has-pdf .fancybox__content {
    width: calc(100% - 120px);
    height: 90%
}

.fancybox__container.is-compact .has-iframe .fancybox__content,
.fancybox__container.is-compact .has-map .fancybox__content,
.fancybox__container.is-compact .has-pdf .fancybox__content {
    width: 100%;
    height: 100%
}

.has-youtube .fancybox__content,
.has-vimeo .fancybox__content,
.has-html5video .fancybox__content {
    width: 960px;
    height: 540px;
    max-width: 100%;
    max-height: 100%
}

.has-map .fancybox__content,
.has-pdf .fancybox__content,
.has-youtube .fancybox__content,
.has-vimeo .fancybox__content,
.has-html5video .fancybox__content {
    padding: 0;
    background: rgba(24, 24, 27, .9);
    color: #fff
}

.has-map .fancybox__content {
    background: #e5e3df
}

.fancybox__html5video,
.fancybox__iframe {
    border: 0;
    display: block;
    height: 100%;
    width: 100%;
    background: rgba(0, 0, 0, 0)
}

.fancybox-placeholder {
    border: 0 !important;
    clip: rect(1px, 1px, 1px, 1px) !important;
    -webkit-clip-path: inset(50%) !important;
    clip-path: inset(50%) !important;
    height: 1px !important;
    margin: -1px !important;
    overflow: hidden !important;
    padding: 0 !important;
    position: absolute !important;
    width: 1px !important;
    white-space: nowrap !important
}

.f-carousel__thumbs {
    --f-thumb-width: 96px;
    --f-thumb-height: 72px;
    --f-thumb-outline: 0;
    --f-thumb-outline-color: #5eb0ef;
    --f-thumb-opacity: 1;
    --f-thumb-hover-opacity: 1;
    --f-thumb-selected-opacity: 1;
    --f-thumb-border-radius: 2px;
    --f-thumb-offset: 0px;
    --f-button-next-pos: 0;
    --f-button-prev-pos: 0
}

.f-carousel__thumbs.is-classic {
    --f-thumb-gap: 8px;
    --f-thumb-opacity: 0.5;
    --f-thumb-hover-opacity: 1;
    --f-thumb-selected-opacity: 1
}

.f-carousel__thumbs.is-modern {
    --f-thumb-gap: 4px;
    --f-thumb-extra-gap: 16px;
    --f-thumb-clip-width: 46px
}

.f-thumbs {
    position: relative;
    flex: 0 0 auto;
    margin: 0;
    overflow: hidden;
    -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
    user-select: none;
    perspective: 1000px;
    transform: translateZ(0)
}

.f-thumbs .f-spinner {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border-radius: 2px;
    background-image: linear-gradient(#ebeff2, #e2e8f0);
    z-index: -1
}

.f-thumbs .f-spinner svg {
    display: none
}

.f-thumbs.is-vertical {
    height: 100%
}

.f-thumbs__viewport {
    width: 100%;
    height: auto;
    overflow: hidden;
    transform: translate3d(0, 0, 0)
}

.f-thumbs__track {
    display: flex
}

.f-thumbs__slide {
    position: relative;
    flex: 0 0 auto;
    box-sizing: content-box;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0;
    margin: 0;
    width: var(--f-thumb-width);
    height: var(--f-thumb-height);
    overflow: visible;
    cursor: pointer
}

.f-thumbs__slide.is-loading img {
    opacity: 0
}

.is-classic .f-thumbs__viewport {
    height: 100%
}

.is-modern .f-thumbs__track {
    width: max-content
}

.is-modern .f-thumbs__track::before {
    content: "";
    position: absolute;
    top: 0;
    bottom: 0;
    left: calc((var(--f-thumb-clip-width, 0))*-0.5);
    width: calc(var(--width, 0)*1px + var(--f-thumb-clip-width, 0));
    cursor: pointer
}

.is-modern .f-thumbs__slide {
    width: var(--f-thumb-clip-width);
    transform: translate3d(calc(var(--shift, 0) * -1px), 0, 0);
    transition: none;
    pointer-events: none
}

.is-modern.is-resting .f-thumbs__slide {
    transition: transform .33s ease
}

.is-modern.is-resting .f-thumbs__slide__button {
    transition: clip-path .33s ease
}

.is-using-tab .is-modern .f-thumbs__slide:focus-within {
    filter: drop-shadow(-1px 0px 0px var(--f-thumb-outline-color)) drop-shadow(2px 0px 0px var(--f-thumb-outline-color)) drop-shadow(0px -1px 0px var(--f-thumb-outline-color)) drop-shadow(0px 2px 0px var(--f-thumb-outline-color))
}

.f-thumbs__slide__button {
    appearance: none;
    width: var(--f-thumb-width);
    height: 100%;
    margin: 0 -100% 0 -100%;
    padding: 0;
    border: 0;
    position: relative;
    border-radius: var(--f-thumb-border-radius);
    overflow: hidden;
    background: rgba(0, 0, 0, 0);
    outline: none;
    cursor: pointer;
    pointer-events: auto;
    touch-action: manipulation;
    opacity: var(--f-thumb-opacity);
    transition: opacity .2s ease
}

.f-thumbs__slide__button:hover {
    opacity: var(--f-thumb-hover-opacity)
}

.f-thumbs__slide__button:focus:not(:focus-visible) {
    outline: none
}

.f-thumbs__slide__button:focus-visible {
    outline: none;
    opacity: var(--f-thumb-selected-opacity)
}

.is-modern .f-thumbs__slide__button {
    --clip-path: inset( 0 calc( ((var(--f-thumb-width, 0) - var(--f-thumb-clip-width, 0))) * (1 - var(--progress, 0)) * 0.5) round var(--f-thumb-border-radius, 0));
    clip-path: var(--clip-path)
}

.is-classic .is-nav-selected .f-thumbs__slide__button {
    opacity: var(--f-thumb-selected-opacity)
}

.is-classic .is-nav-selected .f-thumbs__slide__button::after {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: auto;
    bottom: 0;
    border: var(--f-thumb-outline, 0) solid var(--f-thumb-outline-color, transparent);
    border-radius: var(--f-thumb-border-radius);
    animation: f-fadeIn .2s ease-out;
    z-index: 10
}

.f-thumbs__slide__img {
    overflow: hidden;
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 100%;
    margin: 0;
    padding: var(--f-thumb-offset);
    box-sizing: border-box;
    pointer-events: none;
    object-fit: cover;
    border-radius: var(--f-thumb-border-radius)
}

.f-thumbs.is-horizontal .f-thumbs__track {
    padding: 8px 0 12px 0
}

.f-thumbs.is-horizontal .f-thumbs__slide {
    margin: 0 var(--f-thumb-gap) 0 0
}

.f-thumbs.is-vertical .f-thumbs__track {
    flex-wrap: wrap;
    padding: 0 8px
}

.f-thumbs.is-vertical .f-thumbs__slide {
    margin: 0 0 var(--f-thumb-gap) 0
}

.fancybox__thumbs {
    --f-thumb-width: 96px;
    --f-thumb-height: 72px;
    --f-thumb-border-radius: 2px;
    --f-thumb-outline: 2px;
    --f-thumb-outline-color: #ededed;
    position: relative;
    opacity: var(--fancybox-opacity, 1);
    transition: max-height .35s cubic-bezier(0.23, 1, 0.32, 1)
}

.fancybox__thumbs.is-classic {
    --f-thumb-gap: 8px;
    --f-thumb-opacity: 0.5;
    --f-thumb-hover-opacity: 1
}

.fancybox__thumbs.is-classic .f-spinner {
    background-image: linear-gradient(rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.05))
}

.fancybox__thumbs.is-modern {
    --f-thumb-gap: 4px;
    --f-thumb-extra-gap: 16px;
    --f-thumb-clip-width: 46px;
    --f-thumb-opacity: 1;
    --f-thumb-hover-opacity: 1
}

.fancybox__thumbs.is-modern .f-spinner {
    background-image: linear-gradient(rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.05))
}

.fancybox__thumbs.is-horizontal {
    padding: 0 var(--f-thumb-gap)
}

.fancybox__thumbs.is-vertical {
    padding: var(--f-thumb-gap) 0
}

.is-compact .fancybox__thumbs {
    --f-thumb-width: 64px;
    --f-thumb-clip-width: 32px;
    --f-thumb-height: 48px;
    --f-thumb-extra-gap: 10px
}

.fancybox__thumbs.is-masked {
    max-height: 0px !important
}

.is-closing .fancybox__thumbs {
    transition: none !important
}

.fancybox__toolbar {
    --f-progress-color: var(--fancybox-color, rgba(255, 255, 255, 0.94));
    --f-button-width: 46px;
    --f-button-height: 46px;
    --f-button-color: var(--fancybox-color);
    --f-button-hover-color: var(--fancybox-hover-color);
    --f-button-bg: rgba(24, 24, 27, 0.65);
    --f-button-hover-bg: rgba(70, 70, 73, 0.65);
    --f-button-active-bg: rgba(90, 90, 93, 0.65);
    --f-button-border-radius: 0;
    --f-button-svg-width: 24px;
    --f-button-svg-height: 24px;
    --f-button-svg-stroke-width: 1.5;
    --f-button-svg-filter: drop-shadow(1px 1px 1px rgba(24, 24, 27, 0.15));
    --f-button-svg-fill: none;
    --f-button-svg-disabled-opacity: 0.65;
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    margin: 0;
    padding: 0;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI Adjusted", "Segoe UI", "Liberation Sans", sans-serif;
    color: var(--fancybox-color, currentColor);
    opacity: var(--fancybox-opacity, 1);
    text-shadow: var(--fancybox-toolbar-text-shadow, 1px 1px 1px rgba(0, 0, 0, 0.5));
    pointer-events: none;
    z-index: 20
}

.fancybox__toolbar :focus-visible {
    z-index: 1
}

.fancybox__toolbar.is-absolute,
.is-compact .fancybox__toolbar {
    position: absolute;
    top: 0;
    left: 0;
    right: 0
}

.is-idle .fancybox__toolbar {
    pointer-events: none;
    animation: .15s ease-out both f-fadeOut
}

.fancybox__toolbar__column {
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    align-content: flex-start
}

.fancybox__toolbar__column.is-left,
.fancybox__toolbar__column.is-right {
    flex-grow: 1;
    flex-basis: 0
}

.fancybox__toolbar__column.is-right {
    display: flex;
    justify-content: flex-end;
    flex-wrap: nowrap
}

.fancybox__infobar {
    padding: 0 5px;
    line-height: var(--f-button-height);
    text-align: center;
    font-size: 17px;
    font-variant-numeric: tabular-nums;
    -webkit-font-smoothing: subpixel-antialiased;
    cursor: default;
    user-select: none
}

.fancybox__infobar span {
    padding: 0 5px
}

.fancybox__infobar:not(:first-child):not(:last-child) {
    background: var(--f-button-bg)
}

[data-fancybox-toggle-slideshow] {
    position: relative
}

[data-fancybox-toggle-slideshow] .f-progress {
    height: 100%;
    opacity: .3
}

[data-fancybox-toggle-slideshow] svg g:first-child {
    display: flex
}

[data-fancybox-toggle-slideshow] svg g:last-child {
    display: none
}

.has-slideshow [data-fancybox-toggle-slideshow] svg g:first-child {
    display: none
}

.has-slideshow [data-fancybox-toggle-slideshow] svg g:last-child {
    display: flex
}

[data-fancybox-toggle-fullscreen] svg g:first-child {
    display: flex
}

[data-fancybox-toggle-fullscreen] svg g:last-child {
    display: none
}

:fullscreen [data-fancybox-toggle-fullscreen] svg g:first-child {
    display: none
}

:fullscreen [data-fancybox-toggle-fullscreen] svg g:last-child {
    display: flex
}

.f-progress {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    transform: scaleX(0);
    transform-origin: 0;
    transition-property: transform;
    transition-timing-function: linear;
    background: var(--f-progress-color, var(--f-carousel-theme-color, #0091ff));
    z-index: 30;
    user-select: none;
    pointer-events: none
}

@charset "UTF-8";
@import url("https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap");
*,
:after,
:before {
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
}

html {
    overflow-x: hidden;
    scroll-behavior: smooth;
}

html.no-scroll {
    overflow: hidden;
}

body {
    margin: 0;
    font-family: "Inter", sans-serif;
    background: #252528;
    position: relative;
    padding-bottom: 56px;
    min-height: 100vh;
}
body.lock {
    overflow: hidden;
}
ol,
ul {
    list-style: none;
    margin: 0;
    padding: 0;
}

p {
    padding: 0;
    margin: 0;
    cursor: default;
}

a {
    text-decoration: none;
    cursor: pointer;
}

h1,
h2,
h3 {
    margin: 0;
    font-family: inherit;
}

img {
    display: block;
}

.container {
    max-width: 1336px;
    width: 100%;
    padding: 0 32px;
    margin: 0 auto;
}

@media screen and (max-width: 1024px) {
    .container {
        padding: 0px 32px;
    }
}

@media screen and (max-width: 768px) {
    .container {
        padding: 0px 16px;
    }
}

.btn {
    padding: 11px 16px;
    border-radius: 8px;
    background: #fbfbfb;
    font-size: 14px;
    text-align: center;
    font-weight: 600;
    line-height: normal;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    color: #7a0004;
    cursor: pointer;
}

.btn:hover {
    color: #d33131;
}

.btn.red {
    color: #fff;
    background: var(
        --Linear,
        linear-gradient(180deg, #7a0004 0%, #ba0007 100%)
    );
}

.btn.red:hover {
    background: -webkit-gradient(
        linear,
        left top,
        left bottom,
        from(#b00107),
        to(#ea020b)
    );
    background: linear-gradient(180deg, #b00107 0%, #ea020b 100%);
}

@-webkit-keyframes spin {
    to {
        rotate: -1turn;
    }
}

@keyframes spin {
    to {
        rotate: -1turn;
    }
}

button {
    border: none;
    text-align: center;
}

input {
    border: none;
}

.red {
    background: var(
        --Linear,
        linear-gradient(180deg, #7a0004 0%, #ba0007 100%)
    );
}

.red:hover {
    background: -webkit-gradient(
        linear,
        left top,
        left bottom,
        from(#b00107),
        to(#ea020b)
    );
    background: linear-gradient(180deg, #b00107 0%, #ea020b 100%);
}

.flex {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
}

.slider {
    position: relative;
}

.slick-list {
    overflow: hidden;
}

.slick-track {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
}

.slick-dots {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    gap: 16px;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
}

.slick-dots button {
    background-color: transparent;
    width: 64px;
    height: 56px;
    border-radius: 16px;
    border: 1px solid #1973d3;
    color: #1973d3;
    font-size: 20px;
    font-weight: 500;
    text-transform: uppercase;
    cursor: pointer;
}

@media screen and (max-width: 1024px) {
    .slick-dots button {
        width: 56px;
        height: 48px;
    }
}

.slick-dots li.slick-active button {
    background-color: #1973d3;
    color: #fff;
}

#header {
    position: sticky;
    top: 0;
    width: 100%;
    border-bottom: 1px solid #616166;
    background: #252528;
    z-index: 1000;
    -webkit-transition: all 0.2s linear;
    transition: all 0.2s linear;
    overflow: hidden;
}

#header.hidden {
    -webkit-transform: translateY(-100%);
    transform: translateY(-100%);
}

#header .advertising-banner {
    height: 48px;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    position: relative;
}

#header .advertising-banner img {
    width: 100%;
    height: 100%;
    -o-object-fit: cover;
    object-fit: cover;
    position: absolute;
    z-index: -1;
}

#header .advertising-banner p {
    text-align: center;
    font-family: Inter;
    font-size: 20px;
    font-style: normal;
    font-weight: 700;
    padding: 4px 14px;
    border-radius: 5px;
    background: rgba(217, 217, 217, 0.721);
    width: -webkit-fit-content;
    width: -moz-fit-content;
    width: fit-content;
    color: #990106;
}

@media screen and (max-width: 768px) {
    #header .advertising-banner p {
        font-size: 16px;
        padding: 4px 12px;
    }
}

#header .header-body {
    padding: 8px 10px;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-pack: justify;
    -ms-flex-pack: justify;
    justify-content: space-between;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    position: relative;
    max-width: 1347px;
    margin: 0 auto;
}

@media screen and (max-width: 768px) {
    #header .header-body {
        padding: 8px 16px;
    }
}

#header .left .btn {
    width: 40px;
    height: 40px;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
}

#header .btn {
    height: 40px;
}

#header .logo {
    position: absolute;
    left: 50%;
    top: 50%;
    -webkit-transform: translate(-50%, -50%);
    transform: translate(-50%, -50%);
    color: var(--white, #fbfbfb);
    text-align: right;
    font-family: Inter;
    font-size: 20px;
    font-style: normal;
    font-weight: 700;
    line-height: normal;
    -webkit-transition: all 0.3s linear;
    transition: all 0.3s linear;
}

#header .right {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    gap: 24px;
}

#header .right .btn {
    min-width: 113px;
}

@media screen and (max-width: 768px) {
    #header .right {
        display: none;
    }
}

#header .burger-menu {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    cursor: pointer;
}

#header .header-burger {
    display: none;
    width: 40px;
    height: 40px;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    border-radius: 8px;
    background: var(
        --Linear,
        linear-gradient(180deg, #7a0004 0%, #ba0007 100%)
    );
}

#header .header-burger:hover {
    background: -webkit-gradient(
        linear,
        left top,
        left bottom,
        from(#b00107),
        to(#ea020b)
    );
    background: linear-gradient(180deg, #b00107 0%, #ea020b 100%);
}

@media screen and (max-width: 768px) {
    #header .header-burger {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
    }
}

.coins {
    margin-bottom: 32px;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    gap: 8px;
    color: #ff8a01;
    text-align: center;
    font-family: Inter;
    font-size: 16px;
    font-style: normal;
    font-weight: 600;
    line-height: normal;
}

.coins .add-coins {
    width: 24px;
    height: 24px;
    border-radius: 4px;
    cursor: pointer;
}

.header-wrapper {
    position: relative;
}

.header-menu {
    position: absolute;
    height: 100vh;
    width: 100%;
    max-width: 432px;
    top: 0px;
    right: -100%;
    border-left: 1px solid #616166;
    background: #252528;
    padding: 24px 32px;
    -webkit-transition: all 0.3s ease;
    transition: all 0.3s ease;
    z-index: 10;
}

.header-menu.open {
    right: 0;
}

@media screen and (max-width: 1024px) {
    .header-menu {
        padding: 24px;
        max-width: 350px;
    }
}

@media screen and (max-width: 768px) {
    .header-menu {
        padding: 24px 16px;
    }
}

.header-menu .head {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-pack: justify;
    -ms-flex-pack: justify;
    justify-content: space-between;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    margin-bottom: 16px;
}

.header-menu .user-mail {
    color: #fbfbfb;
    font-size: 17px;
    font-weight: 500;
    line-height: normal;
}

.header-menu .close {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    cursor: pointer;
}

.header-menu .search-container {
    position: relative;
    margin-bottom: 12px;
}

.header-menu .search-container .search-input {
    width: 100%;
    padding: 12px;
    border: none;
    border-radius: 8px;
    background: #525252;
    color: #fff;
    font-size: 16px;
    outline: none;
}

.header-menu .search-container .search-button {
    position: absolute;
    right: 12px;
    top: 50%;
    -webkit-transform: translateY(-50%);
    transform: translateY(-50%);
    background: none;
    border: none;
    cursor: pointer;
    opacity: 0.6;
}

.header-menu .search-container .search-button img {
    width: 20px;
    height: 20px;
}

.header-menu .form-container {
    padding: 16px 0;
    border-top: 1px solid #525252;
    border-bottom: 1px solid #525252;
}

.header-menu .form-container form .form-fields {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-pack: justify;
    -ms-flex-pack: justify;
    justify-content: space-between;
    gap: 10px;
}

.header-menu .form-container form .btn {
    width: 100%;
    margin-top: 12px;
}

.header-menu .form-container .form-group {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-pack: justify;
    -ms-flex-pack: justify;
    justify-content: space-between;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    gap: 10px;
    width: 33.33%;
}

.header-menu .form-container .form-group label {
    color: #fbfbfb;
    text-align: center;
    font-size: 16px;
    font-weight: 600;
    line-height: normal;
}

.header-menu .form-container select {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    background-color: transparent;
    color: #fbfbfb;
    border: none;
    font-size: 16px;
    font-weight: 400;
    line-height: normal;
    background-image: url("../img/select.svg");
    background-repeat: no-repeat;
    background-position: right 0.3rem top 50%;
    background-size: 0.99rem auto;
    background-color: #252528;
    border-radius: 8px;
    border: 1px solid #525252;
    padding: 12px;
    width: 100%;
}

.header-menu .form-container .zip-distance-group {
    width: 33.33%;
}

.header-menu .form-container .zip-distance-group input {
    padding: 12px;
    border: none;
    border-radius: 8px;
    background: #525252;
    color: #fff;
    font-size: 16px;
    outline: none;
    width: 100%;
}

.header-menu .pages {
    padding-top: 24px;
}

.header-menu .pages .pages-list {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    gap: 16px;
}

.header-menu .pages .pages-item {
    width: calc((100% - 16px) / 2);
    padding: 8px;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    gap: 4px;
    border-radius: 4px;
}

.header-menu .pages .name {
    color: #fbfbfb;
    text-align: center;
    font-size: 14px;
    font-weight: 400;
    line-height: normal;
}

.footer {
    position: absolute;
    bottom: 0;
    width: 100%;
    border-top: 1px solid #525252;
}

.footer .footer-container {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    gap: 56px;
    padding: 16px;
}

.footer .footer-link {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    gap: 8px;
    color: var(--white, #fbfbfb);
    font-size: 14px;
    font-style: normal;
    font-weight: 600;
    line-height: normal;
}

.footer .footer-link:hover {
    text-decoration: underline;
}

.users {
    padding: 40px 0;
}

.users.vote {
    padding-bottom: 0;
}

.users.vote .users-list {
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
}

.users .users-list {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    gap: 32px;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
}

@media screen and (max-width: 1024px) {
    .users .users-list {
        gap: 24px;
    }
}

.users .users-item {
    width: calc((100% - 96px) / 4);
    background: #39393e;
    border-radius: 16px;
    overflow: hidden;
    -webkit-transition: all 0.1s ease;
    transition: all 0.1s ease;
    position: relative;
    min-height: 499px;
}

@media screen and (max-width: 1024px) {
    .users .users-item {
        width: calc((100% - 24px) / 2);
    }
}

@media screen and (max-width: 768px) {
    .users .users-item {
        width: 100%;
        min-height: 480px;
        max-height: 550px;
        height: 550px;
    }
}

.users .users-item:hover {
    background: #4c4c52;
}

.users .users-item.verified:after {
    content: "Verified";
    width: 72px;
    height: 72px;
    border-radius: 50%;
    background: #fff;
    -webkit-box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
    box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    position: absolute;
    z-index: 100;
    font-size: 14px;
    font-weight: 700;
    -webkit-transform: rotate(-9.647deg);
    transform: rotate(-9.647deg);
    color: #b12828;
    top: 280px;
    right: 8px;
}

@media screen and (max-width: 1024px) {
    .users .users-item.verified:after {
        top: 300px;
    }
}

.users .users-item.add {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    font-size: 64px;
    font-style: normal;
    font-weight: 600;
    color: #fbfbfb;
}

.users .users-item.add img {
    width: 100%;
    height: 100%;
    -o-object-fit: cover;
    object-fit: cover;
    -o-object-position: center;
    object-position: center;
}

.users .users-item.battle {
    border: 0.1px solid #d33131;
    -webkit-box-shadow: 0px 4px 20px 0px rgba(211, 49, 49, 0.44);
    box-shadow: 0px 4px 20px 0px rgba(211, 49, 49, 0.44);
}

.users .user-image {
    position: relative;
}

.users .user-image .img-slider {
    height: 319px;
}

@media screen and (max-width: 1024px) {
    .users .user-image .img-slider {
        height: 399px;
    }
}

.users .user-image .img-slider .slick-list {
    height: 100%;
}

.users .user-image .img-slider .slick-track {
    height: 100%;
}

.users .user-image .img-slider .slide {
    height: 100%;
}

.users .user-image .img-slider .slide img {
    height: 100%;
    width: 100%;
    -o-object-fit: cover;
    object-fit: cover;
}

.users .user-image .slider-navigation {
    position: absolute;
    top: 50%;
    -webkit-transform: translateY(-50%);
    transform: translateY(-50%);
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-pack: justify;
    -ms-flex-pack: justify;
    justify-content: space-between;
    width: 100%;
    z-index: 100;
    padding: 12px;
}

.users .user-image .next,
.users .user-image .prev {
    width: 23px;
    height: 23px;
    border-radius: 4px;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    -webkit-transition: all 0.1s ease;
    transition: all 0.1s ease;
    background: var(
        --Linear,
        linear-gradient(180deg, #7a0004 0%, #ba0007 100%)
    );
}

.users .user-image .next:hover,
.users .user-image .prev:hover {
    background: -webkit-gradient(
        linear,
        left top,
        left bottom,
        from(#b00107),
        to(#ea020b)
    );
    background: linear-gradient(180deg, #b00107 0%, #ea020b 100%);
}

.users .user-image .likes {
    position: absolute;
    top: 16px;
    left: 16px;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    gap: 8px;
    z-index: 100;
}

.users .user-image .likes .btn {
    padding: 0;
    width: 24px;
    height: 24px;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
}

.users .user-image .likes .likes-count {
    color: #fbfbfb;
    font-size: 14px;
    font-weight: 600;
    line-height: normal;
}

.users .user-image .likes.active .btn {
    background: #fff !important;
}

.users .user-image .likes.active path {
    fill: rgb(164, 0, 0);
}

.users .card {
    padding: 12px;
}
.users .title {
    color: var(--white, #fbfbfb);
    font-family: Inter;
    font-size: 20px;
    font-style: normal;
    font-weight: 700;
    line-height: normal;
    margin-bottom: 4px;
    display: flex;
    gap: 4px;
}
.users .title .user-name {
    max-width: 130px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.users .place {
    color: var(--light-gray, #bebfc0);
    font-family: Inter;
    font-size: 16px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;
    margin-bottom: 8px;
}

.users .about {
    overflow: hidden;
    color: var(--light-gray, #bebfc0);
    text-overflow: ellipsis;
    font-family: Inter;
    font-size: 15px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;
    display: -webkit-box;
    -webkit-line-clamp: 5;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
}

.battle-container {
    height: 100%;
    position: relative;
}

.battle-container .startBattle {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border-radius: 0px 16px 16px 0px;
    background: rgba(57, 57, 62, 0.5);
    -webkit-backdrop-filter: blur(15px);
    backdrop-filter: blur(15px);
    z-index: 100;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    -webkit-transition: all 0.9s ease;
    transition: all 0.9s ease;
}

.battle-container .startBattle .start_btn {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    background: var(
        --Linear,
        linear-gradient(180deg, #7a0004 0%, #ba0007 100%)
    );
    color: var(--white, #fbfbfb);
    font-size: 14px;
    font-weight: 600;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    cursor: pointer;
    position: relative;
}

.battle-container .startBattle .start_btn:before {
    content: "Vote";
    position: absolute;
    top: -36px;
    font-size: 20px;
}

.battle-container .startBattle .start_btn:after {
    content: "Battle";
    position: absolute;
    bottom: -36px;
    font-size: 20px;
}

.battle-container .startBattle.hidden {
    bottom: -100%;
}

.battle-container .loader .loader-L {
    position: absolute;
    left: -100%;
    top: 0;
    height: 100%;
    width: 50%;
    background: rgba(57, 57, 62, 0.5);
    -webkit-backdrop-filter: blur(25px);
    backdrop-filter: blur(25px);
    z-index: 100;
    -webkit-transition: all 0.3s ease-in-out;
    transition: all 0.3s ease-in-out;
}

.battle-container .loader .loader-R {
    position: absolute;
    right: -100%;
    top: 0;
    height: 100%;
    width: 50%;
    background: rgba(57, 57, 62, 0.5);
    -webkit-backdrop-filter: blur(25px);
    backdrop-filter: blur(25px);
    z-index: 100;
    -webkit-transition: all 0.3s ease-in-out;
    transition: all 0.3s ease-in-out;
}

.battle-container .loader.open .loader-R {
    right: 0;
}

.battle-container .loader.open .loader-L {
    left: 0;
}

.battle-container .photo-battle {
    position: relative;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    height: 100%;
    background-color: rgba(39, 39, 39, 0.9725490196);
}

.battle-container .photo-battle .repeat {
    position: absolute;
    bottom: 8px;
    left: 50%;
    -webkit-transform: translateX(-50%);
    transform: translateX(-50%);
    width: 70px;
    height: 70px;
    border-radius: 50%;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    z-index: 10;
    background: -webkit-gradient(
        linear,
        left top,
        left bottom,
        from(#725354),
        to(#827d7d)
    );
    background: linear-gradient(180deg, #725354 0%, #827d7d 100%);
    font-size: 14px;
    font-weight: 600;
    color: #bebfc0;
    cursor: not-allowed;
}

.battle-container .photo-battle .repeat.active {
    cursor: pointer;
    background: var(
        --Linear,
        linear-gradient(180deg, #7a0004 0%, #ba0007 100%)
    );
    color: #fbfbfb;
}

.battle-container .photo-battle .repeat.active .progress-ring {
    display: none;
}

.battle-container .photo-battle .repeat .progress-ring {
    position: absolute;
    top: -5px;
    left: -5px;
    width: 80px;
    height: 80px;
    -webkit-transform: rotate(-90deg);
    transform: rotate(-90deg);
}

.battle-container .photo-battle .repeat .progress-ring__circle {
    -webkit-transition: stroke-dasharray 6s linear;
    transition: stroke-dasharray 6s linear;
    stroke-dasharray: 0 213.6;
}

.battle-container .photo-container {
    width: 50%;
    position: relative;
    overflow: hidden;
    -webkit-transition: width 0.5s ease, -webkit-filter 0.5s ease;
    transition: width 0.5s ease, -webkit-filter 0.5s ease;
    transition: width 0.5s ease, filter 0.5s ease;
    transition: width 0.5s ease, filter 0.5s ease, -webkit-filter 0.5s ease;
    height: 100%;
    cursor: pointer;
}

.battle-container .photo-container img {
    width: 100%;
    height: 100%;
    -o-object-fit: cover;
    object-fit: cover;
}

.battle-container .photo-container .info {
    position: absolute;
    top: 8px;
    left: 8px;
    color: white;
    font-family: Inter;
    font-size: 20px;
    border-radius: 5px;
    white-space: nowrap;
    font-weight: 700;
}

.battle-container .photo-container.blurred {
    -webkit-filter: blur(10px);
    filter: blur(10px);
    width: 15%;
}

.battle-container .photo-container.selected {
    width: 85%;
}

.pagination {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    margin-top: 32px;
    gap: 8px;
}

.pagination .pagination-list {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    justify-content: center;
}

.pagination .pagination-list a {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 4px;
    background: #39393e;
    color: var(--white, #fbfbfb);
    font-size: 16px;
    font-weight: 400;
    line-height: normal;
    -webkit-transition: all 0.1s ease;
    transition: all 0.1s ease;
}

.pagination .pagination-list a:hover {
    background: #4c4c52;
}

.pagination .pagination-list a.current {
    background: #838383;
}

.pagination .next,
.pagination .prev {
    min-width: 40px;
    width: 40px;
    height: 40px;
    border-radius: 4px;
    cursor: pointer;
    background: var(
        --Linear,
        linear-gradient(180deg, #7a0004 0%, #ba0007 100%)
    );
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
}

.pagination .next:hover,
.pagination .prev:hover {
    background: -webkit-gradient(
        linear,
        left top,
        left bottom,
        from(#b00107),
        to(#ea020b)
    );
    background: linear-gradient(180deg, #b00107 0%, #ea020b 100%);
}

.popUp-wrapper {
    background: rgba(0, 0, 0, 0.8);
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 999;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    display: none;
}

.popUp-wrapper.active {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
}

@media screen and (max-width: 768px) {
    .popUp-wrapper {
        -webkit-box-pack: end;
        -ms-flex-pack: end;
        justify-content: flex-end;
    }
}

.popUp-wrapper.settings-popup {
    background: rgba(22, 21, 21, 0.51);
    z-index: 1000;
}

@media screen and (max-width: 768px) {
    .popUp-wrapper.settings-popup {
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        justify-content: center;
    }
}

.popUp-wrapper.settings-popup .card {
    padding: 24px;
    background: #525252;
}

.popUp-wrapper.settings-popup .card input {
    background: #39393e;
}

@media screen and (max-width: 768px) {
    .popUp-wrapper.settings-popup .card {
        border-radius: 8px;
        padding: 16px;
        height: auto;
        max-width: 424px;
    }
}

.popUp-wrapper .card {
    border-radius: 16px;
    background: #252528;
    padding: 16px 16px 48px;
    width: 100%;
    position: relative;
    max-width: 424px;
    display: none;
}

@media screen and (max-width: 768px) {
    .popUp-wrapper .card {
        height: 100%;
        z-index: 100000;
        border-radius: 0;
        max-width: 350px;
    }
}

.popUp-wrapper .card.active {
    display: block;
}

.popUp-wrapper .card .close {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    background: var(
        --Linear,
        linear-gradient(180deg, #7a0004 0%, #ba0007 100%)
    );
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    position: absolute;
    right: 16px;
    top: 16px;
    cursor: pointer;
}
.add-new-pass {
    padding-top: 40px;
}
.popUp-wrapper .card .close:hover {
    background: -webkit-gradient(
        linear,
        left top,
        left bottom,
        from(#b00107),
        to(#ea020b)
    );
    background: linear-gradient(180deg, #b00107 0%, #ea020b 100%);
}

.popUp-wrapper .card form {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
}

.popUp-wrapper .card .title {
    color: #fbfbfb;
    text-align: center;
    font-family: Inter;
    font-size: 18px;
    font-style: normal;
    font-weight: 600;
    line-height: normal;
    height: 40px;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    margin-bottom: 12px;
}

.popUp-wrapper .resetPassword-card {
    border-radius: 8px !important;
    padding-top: 55px;
    padding-bottom: 16px;
}

@media screen and (max-width: 768px) {
    .popUp-wrapper .resetPassword-card {
        height: auto;
        position: absolute;
        left: 50%;
        top: 50%;
        -webkit-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
    }
}

.popUp-wrapper .resetPassword-card .submit {
    background-color: #d32f2f;
    color: white;
    padding: 10px;
    border: none;
    border-radius: 5px;
    width: 100%;
    cursor: pointer;
}

.popUp-wrapper .input-group {
    margin-bottom: 16px;
    position: relative;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    gap: 8px;
}

.popUp-wrapper .input-group.error input {
    background: #8c4444 !important;
}

.popUp-wrapper .input-group.error .error-text {
    display: block;
}

.popUp-wrapper .input-group label {
    display: block;
    color: #fbfbfb;
    font-family: Inter;
    font-size: 14px;
    font-weight: 400;
    line-height: normal;
}

.popUp-wrapper .input-group .error-text {
    color: #ff5959;
    font-family: Inter;
    font-size: 13px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;
    display: none;
}

.popUp-wrapper .input-group input {
    width: 100%;
    padding: 12px;
    border-radius: 8px;
    background: #525252;
    color: #fff;
    font-weight: 400;
    font-size: 16px;
}

.popUp-wrapper .input-group input::-webkit-input-placeholder {
    color: var(--light-gray, #bebfc0);
    font-family: Inter;
    font-size: 15px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;
}

.popUp-wrapper .input-group input::-moz-placeholder {
    color: var(--light-gray, #bebfc0);
    font-family: Inter;
    font-size: 15px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;
}

.popUp-wrapper .input-group input:-ms-input-placeholder {
    color: var(--light-gray, #bebfc0);
    font-family: Inter;
    font-size: 15px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;
}

.popUp-wrapper .input-group input::-ms-input-placeholder {
    color: var(--light-gray, #bebfc0);
    font-family: Inter;
    font-size: 15px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;
}

.popUp-wrapper .input-group input::placeholder {
    color: var(--light-gray, #bebfc0);
    font-family: Inter;
    font-size: 15px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;
}

.popUp-wrapper .input-group .reset-pass {
    text-align: right;
    cursor: pointer;
}

.popUp-wrapper .input-group .reset-pass:hover {
    text-decoration: underline;
}

.popUp-wrapper .input-group .show-password {
    position: absolute;
    right: 12px;
    top: 36px;
    cursor: pointer;
    opacity: 0.8;
}

.popUp-wrapper .input-group .show-password:hover {
    opacity: 1;
}

.popUp-wrapper .input-group .show-password.open:before {
    content: "";
    width: 100%;
    height: 1px;
    background-color: #fff;
    position: absolute;
    top: 50%;
    left: 0;
    border-radius: 2px;
    -webkit-transform: translatey(-50%) rotate(45deg);
    transform: translatey(-50%) rotate(45deg);
}

.popUp-wrapper .res-succes-send {
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    gap: 16px;
    padding: 16px;
    background: #525252;
}

.popUp-wrapper .res-succes-send .title {
    margin: 0;
}

.popUp-wrapper .res-succes-send .mail {
    color: #56b1f3;
    text-align: center;
    font-size: 16px;
}

.popUp-wrapper .addNew-pass-card {
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    padding: 16px 16px 24px;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
}

.popUp-wrapper .pass-succes {
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    padding: 16px;
}

@media screen and (max-width: 768px) {
    .popUp-wrapper .pass-succes {
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        justify-content: center;
    }
}

.popUp-wrapper .passRule,
.popUp-wrapper .reset-pass,
.popUp-wrapper .switch-to-signup,
.popUp-wrapper .switch-to-login {
    color: var(--white, #fbfbfb);
    font-family: Inter;
    font-size: 13px;
    font-style: normal;
    font-weight: 400;
    line-height: 120%;
}

.popUp-wrapper .switch-to-signup,
.popUp-wrapper .switch-to-login {
    font-size: 14px;
    text-align: center;
    margin-top: 16px;
}

.popUp-wrapper .switch-to-signup span,
.popUp-wrapper .switch-to-login span {
    color: #fb2e35;
    cursor: pointer;
}

.popUp-wrapper .switch-to-signup span:hover,
.popUp-wrapper .switch-to-login span:hover {
    text-decoration: underline;
}

.popUp-wrapper .submit {
    width: 100%;
    border: none;
    border-radius: 8px;
    color: white;
    font-size: 16px;
    cursor: pointer;
}

.popUp-wrapper .submit:disabled {
    opacity: 0.4;
    pointer-events: none;
}

.verification-wrapper {
    background: rgba(0, 0, 0, 0.8);
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 999;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    padding: 16px;
    display: none;
}

.verification-wrapper.active {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
}

.verification-wrapper .verification-container {
    border-radius: 16px;
    background: #252528;
    color: #fff;
    padding: 24px 16px;
    text-align: center;
    width: 100%;
    max-width: 424px;
}

.verification-wrapper .verification-container .title {
    color: #fbfbfb;
    text-align: center;
    font-size: 16px;
    font-weight: 500;
    max-width: 300px;
    margin: 0 auto;
}

.verification-wrapper .verification-container .email {
    color: #56b1f3;
    text-align: center;
    font-size: 14px;
    margin-top: 8px;
}

.verification-wrapper .verification-container .code-inputs {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    gap: 13px;
    margin: 20px 0;
    position: relative;
}

.verification-wrapper .verification-container .code-inputs.error {
    padding-bottom: 24px;
}

.verification-wrapper .verification-container .code-inputs.error input {
    background: #8c4444 !important;
}

.verification-wrapper .verification-container .code-inputs.error .error-text {
    position: absolute;
    bottom: 0;
    color: #ff5959;
    text-align: center;
    font-size: 14px;
}

.verification-wrapper .verification-container .code-inputs input {
    width: 40px;
    height: 50px;
    font-size: 18px;
    text-align: center;
    border-radius: 4px;
    color: #fff;
    background: #39393e;
}

.verification-wrapper .verification-container .again {
    color: #9ea1a4;
    text-align: center;
    font-size: 14px;
    cursor: pointer;
}

.verification-wrapper .verification-container .again:hover {
    text-decoration: underline;
}

.verification-wrapper .verification-container #countdown {
    color: #fbfbfb;
    font-size: 14px;
}

.advertising-wrapper {
    background: rgba(0, 0, 0, 0.8);
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 999;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    gap: 19px;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    display: none;
    padding: 16px;
}

.advertising-wrapper .advertising-popup {
    border-radius: 8px;
    overflow: hidden;
    width: 100%;
    max-width: 610px;
    height: 343px;
}

.advertising-wrapper .advertising-popup img {
    width: 100%;
    height: 100%;
    -o-object-fit: cover;
    object-fit: cover;
}

.advertising-wrapper .advertising-close-timer {
    width: 100%;
    max-width: 209px;
    color: #fbfbfb;
    gap: 8px;
    height: 40px;
}

.advertising-wrapper .advertising-close-timer.disabled {
    background: -webkit-gradient(
        linear,
        left top,
        left bottom,
        from(#554142),
        to(#8b7778)
    );
    background: linear-gradient(180deg, #554142 0%, #8b7778 100%);
    pointer-events: none;
}

.advertising-wrapper .advertising-close-timer.enabled .timer {
    display: none;
}

.advertising-wrapper .advertising-close-timer .timer {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    width: 24px;
    height: 24px;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    border: 1px solid #fff;
    border-radius: 50%;
    font-size: 14px;
    font-style: normal;
    font-weight: 400;
}

.profile {
    padding: 21px 0;
}

.profile .container {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    gap: 16px;
    max-width: 1100px;
}

@media screen and (max-width: 768px) {
    .profile .container {
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
        gap: 24px;
    }
}

.profile .info-group {
    position: relative;
}

.profile .info-group.pending:after {
    content: "Pending up to 72h...";
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    border-radius: 8px;
    background: rgba(57, 57, 62, 0.5);
    -webkit-backdrop-filter: blur(25px);
    backdrop-filter: blur(25px);
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    color: var(--white, #fbfbfb);
    text-align: center;
    font-family: Inter;
    font-size: 20px;
    font-style: normal;
}

.profile .info-group.rejected .reject {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
}

.profile .info-group .reject {
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    border-radius: 8px;
    background: rgba(57, 57, 62, 0.5);
    -webkit-backdrop-filter: blur(25px);
    backdrop-filter: blur(25px);
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    color: var(--white, #fbfbfb);
    text-align: center;
    font-family: Inter;
    font-size: 20px;
    font-style: normal;
    z-index: 999;
    display: none;
}

.profile .info-group .reject .reason {
    max-width: 200px;
    color: #ff5959;
    text-align: center;
    font-size: 20px;
    font-weight: 700;
}

.profile .left-side {
    width: 44%;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    gap: 8px;
}

@media screen and (max-width: 768px) {
    .profile .left-side {
        width: 100%;
        height: auto;
    }
}

.profile .left-side .head-porfile {
    border-radius: 8px;
    background: #39393e;
    overflow: hidden;
    position: relative;
}

.profile .left-side .head-porfile.verified:after {
    content: "Verified";
    width: 72px;
    height: 72px;
    border-radius: 50%;
    background: #fff;
    -webkit-box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
    box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    position: absolute;
    z-index: 100;
    font-size: 14px;
    font-weight: 700;
    -webkit-transform: rotate(-9.647deg);
    transform: rotate(-9.647deg);
    color: #b12828;
    top: 380px;
    right: 8px;
}

@media screen and (max-width: 1024px) {
    .profile .left-side .head-porfile.verified:after {
        top: 300px;
    }
}

.profile .left-side .head-porfile .img-card {
    position: relative;
}

.profile .left-side .head-porfile .img-card img:not(.likes img) {
    width: 100%;
    height: 427px;
    -o-object-fit: cover;
    object-fit: cover;
}

@media screen and (max-width: 1024px) {
    .profile .left-side .head-porfile .img-card img:not(.likes img) {
        height: 266px;
    }
}

@media screen and (max-width: 768px) {
    .profile .left-side .head-porfile .img-card img:not(.likes img) {
        height: 339px;
    }
}

.profile .left-side .head-porfile .img-card .likes {
    position: absolute;
    top: 8px;
    left: 8px;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    gap: 8px;
}

.profile .left-side .head-porfile .img-card .likes .btn {
    padding: 0;
    width: 24px;
    height: 24px;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
}

.profile .left-side .head-porfile .img-card .likes .likes-count {
    color: #fbfbfb;
    font-size: 14px;
    font-weight: 600;
    line-height: normal;
}

.profile .left-side .head-porfile .img-card .likes.active .btn {
    background: #fff !important;
}

.profile .left-side .head-porfile .img-card .likes.active path {
    fill: rgb(164, 0, 0);
}

.profile .left-side .head-porfile .userMain {
    padding: 12px;
}

.profile .left-side .head-porfile .name {
    color: var(--white, #fbfbfb);
    font-size: 24px;
    font-weight: 700;
}

.profile .left-side .head-porfile .city {
    color: var(--light-gray, #bebfc0);
    font-size: 16px;
    line-height: normal;
}

.profile .left-side .user-info-list {
    border-radius: 8px;
    background: #39393e;
    padding: 12px;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    gap: 12px;
}

.profile .left-side .user-info-list .user-info-item {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    gap: 4px;
    font-size: 16px;
}

.profile .left-side .user-info-list .type {
    color: #bebfc0;
}

.profile .left-side .user-info-list .info {
    color: #fbfbfb;
    font-weight: 600;
}

.profile .left-side .user-location {
    overflow: hidden;
    border-radius: 8px;
    height: 219px;
}

.profile .left-side .description {
    border-radius: 8px;
    background: #39393e;
    padding: 12px;
    color: #bebfc0;
    font-size: 15px;
    line-height: normal;
}

.profile .user-photo-list {
    width: 44%;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    gap: 16px;
}

@media screen and (max-width: 768px) {
    .profile .user-photo-list {
        width: 100%;
    }
}

.profile .user-photo-list .user-photo-item {
    border-radius: 8px;
    overflow: hidden;
    display: block;
    position: relative;
}

.profile .user-photo-list .user-photo-item .subscribe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    background: rgba(0, 0, 0, 0.22);
    -webkit-backdrop-filter: blur(25px);
    backdrop-filter: blur(25px);
}

.profile .user-photo-list .user-photo-item .subscribe p {
    color: #fbfbfb;
    text-align: center;
    font-size: 20px;
    font-weight: 700;
}

.profile .user-photo-list .user-photo-item .subscribe .btn {
    width: -webkit-fit-content;
    width: -moz-fit-content;
    width: fit-content;
    margin-top: 12px;
}

.profile .user-photo-list .user-photo-item img {
    width: 100%;
    height: 500px;
    -o-object-fit: cover;
    object-fit: cover;
}

@media screen and (max-width: 1024px) {
    .profile .user-photo-list .user-photo-item img {
        height: 356px;
    }
}

@media screen and (max-width: 768px) {
    .profile .user-photo-list .user-photo-item img {
        height: 339px;
    }
}

.profile .other-user-list {
    width: 12%;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    gap: 12px;
}

@media screen and (max-width: 768px) {
    .profile .other-user-list {
        width: 100%;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        -webkit-box-orient: horizontal;
        -webkit-box-direction: normal;
        -ms-flex-direction: row;
        flex-direction: row;
    }
}

.profile .other-user-list .other-user-item {
    overflow: hidden;
    border-radius: 8px;
    background: #4c4c52;
    position: relative;
}

@media screen and (max-width: 768px) {
    .profile .other-user-list .other-user-item {
        width: calc((100% - 12px) / 2);
    }
    .profile .other-user-list .other-user-item:not(:nth-child(-n + 4)) {
        display: none;
    }
}

.profile .other-user-list .other-user-item:hover {
    background-color: #606068;
}

.profile .other-user-list .other-user-item.verified:after {
    content: "Verified";
    width: 35px;
    height: 35px;
    border-radius: 50%;
    background: #fff;
    -webkit-box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
    box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    position: absolute;
    z-index: 100;
    font-size: 8px;
    font-weight: 700;
    -webkit-transform: rotate(-9.647deg);
    transform: rotate(-9.647deg);
    color: #b12828;
    top: 100px;
    right: 4px;
}

@media screen and (max-width: 768px) {
    .profile .other-user-list .other-user-item.verified:after {
        top: 120px;
    }
}

.profile .other-user-list .other-user-item img:not(.likes img) {
    width: 100%;
    height: 116px;
    -o-object-fit: cover;
    object-fit: cover;
}

@media screen and (max-width: 768px) {
    .profile .other-user-list .other-user-item img:not(.likes img) {
        height: 139px;
    }
}

.profile .other-user-list .likes {
    position: absolute;
    top: 8px;
    left: 8px;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    gap: 4px;
}

.profile .other-user-list .likes .btn {
    padding: 0;
    width: 16px;
    height: 16px;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    border-radius: 4px !important;
}

.profile .other-user-list .likes .btn img {
    width: 10px;
}

.profile .other-user-list .likes .likes-count {
    color: #fbfbfb;
    font-size: 10px;
    font-weight: 600;
    line-height: normal;
}

.profile .other-user-list .likes.active .btn {
    background: #fff !important;
}

.profile .other-user-list .likes.active path {
    fill: rgb(164, 0, 0);
}

.profile .other-user-list .card {
    padding: 8px;
}

.profile .other-user-list .card .name {
    color: var(--white, #fbfbfb);
    font-size: 12px;
    font-weight: 700;
}

.profile .other-user-list .card .city {
    color: var(--light-gray, #bebfc0);
    font-size: 10px;
    line-height: normal;
}

.profile.account .left-side {
    gap: 24px;
}

@media screen and (max-width: 1024px) {
    .profile.account .left-side {
        gap: 16px;
    }
}

.profile.account .left-side,
.profile.account .user-photo-list {
    width: 50%;
}

@media screen and (max-width: 768px) {
    .profile.account .left-side,
    .profile.account .user-photo-list {
        width: 100%;
    }
}

.profile.account .container {
    max-width: 950px;
}

.profile.account .left-card {
    border-radius: 16px;
    background: #39393e;
    padding: 24px;
    width: 100%;
}

.profile.account .left-card .title {
    color: #fbfbfb;
    text-align: center;
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 12px;
}

.profile.account .left-card .statistic-list {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    gap: 12px;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
}

.profile.account .left-card .statistic-list .statistic-item {
    color: #fbfbfb;
    font-size: 16px;
}

.profile.account .left-card .statistic-list .statistic-item span {
    color: #bebfc0;
    text-align: center;
    font-size: 16px;
}

.profile.account .edit-info-btn {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    margin-top: 40px;
}

.profile.account .edit-info-btn .btn {
    width: 100%;
    max-width: 343px;
}

@media screen and (max-width: 768px) {
    .profile.account .edit-info-btn {
        margin-top: 24px;
    }
}

.profile.account .delete-wrapper {
    padding: 16px;
    position: fixed;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    z-index: 10000;
    background: rgba(37, 37, 40, 0.43);
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    display: none;
}

.profile.account .delete-wrapper.active {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
}

.profile.account .delete-wrapper .delete-popup {
    border-radius: 8px;
    background: #39393e;
    padding: 24px;
    max-width: 427px;
}

.profile.account .delete-wrapper .title {
    color: #fbfbfb;
    text-align: center;
    font-size: 20px;
    font-weight: 600;
    margin-bottom: 24px;
}

.profile.account .delete-wrapper .btn-group {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    gap: 8px;
}

.profile.account .delete-wrapper .btn {
    width: 50%;
}

.profile.account .delete-wrapper .white {
    color: #000;
}

.profile.account .user-location {
    height: -webkit-fit-content;
    height: -moz-fit-content;
    height: fit-content;
    overflow: hidden;
}

.profile.account .user-location iframe {
    height: 250px;
}

.profile.account .location-address {
    padding: 8px;
    color: #fbfbfb;
    padding: 8px;
    border-radius: 8px;
    background: #39393e;
    margin-top: 12px;
}

.profile .info-title {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    gap: 8px;
    color: #fbfbfb;
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 4px;
}

.profile .user-location {
    background: #39393e;
}

.profile .user-location .info-title {
    padding: 12px;
}

.profile .description .info-title {
    margin-bottom: 12px;
}

.toggle-container {
    margin-top: 32px;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    gap: 16px;
}

.toggle-container .toggle-group {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    gap: 12px;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
}

.toggle-container .toggle-group label {
    white-space: nowrap;
    color: #fbfbfb;
    text-align: center;
    font-family: Inter;
    font-size: 16px;
    font-weight: 600;
}

.toggle-container .toggle-group .toggle-body {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    gap: 16px;
}

.toggle-container .toggle-group .toggle-body span {
    color: #fbfbfb;
    text-align: center;
    font-size: 16px;
}

.toggle-container .toggle-group .toggle {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 32px;
}

.toggle-container .toggle-group .toggle input {
    opacity: 0;
    width: 0;
    height: 0;
}

.toggle-container .toggle-group .toggle .slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(204, 204, 204, 0);
    outline: 1px solid #919090;
    -webkit-transition: 0.4s;
    transition: 0.4s;
    border-radius: 34px;
}

.toggle-container .toggle-group .toggle .slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 3px;
    background-color: #919191;
    -webkit-transition: 0.4s;
    transition: 0.4s;
    border-radius: 50%;
}

.toggle-container .toggle-group .toggle input:checked + .slider {
    outline: 1px solid #fff;
}

.toggle-container .toggle-group .toggle input:checked + .slider:before {
    -webkit-transform: translateX(26px);
    transform: translateX(26px);
    background-color: #fff;
}

.toggle-container .toggle-group span {
    display: inline-block;
}

.toggle-container .info-text a,
.toggle-container p {
    cursor: pointer;
    background: var(
        --Linear,
        linear-gradient(180deg, #7a0004 0%, #ba0007 100%)
    );
    background-clip: text;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    display: block;
    text-align: center;
}

.toggle-container .info-text a:hover,
.toggle-container p:hover {
    text-decoration: underline;
}

.profile-filling {
    padding: 40px 0;
}

.profile-filling .container {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    max-width: 1100px;
    width: 100%;
    gap: 24px;
}

@media screen and (max-width: 768px) {
    .profile-filling .container {
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
        gap: 40px;
    }
}

.profile-filling .left-card {
    border-radius: 16px;
    background: #39393e;
    padding: 24px;
    width: 38%;
    height: -webkit-fit-content;
    height: -moz-fit-content;
    height: fit-content;
}

@media screen and (max-width: 768px) {
    .profile-filling .left-card {
        padding: 0;
        width: 100%;
        background: none;
    }
}

.profile-filling .left-card .title {
    color: #fbfbfb;
    text-align: center;
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 12px;
}

.profile-filling .left-card .statistic-list {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    gap: 12px;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
}

.profile-filling .left-card .statistic-list .statistic-item {
    color: #fbfbfb;
    font-size: 16px;
}

.profile-filling .left-card .statistic-list .statistic-item span {
    color: #bebfc0;
    text-align: center;
    font-size: 16px;
}

.profile-filling .form-container {
    width: 62%;
}

.profile-filling .form-container #multiStepForm {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    gap: 16px;
}

@media screen and (max-width: 768px) {
    .profile-filling .form-container {
        width: 100%;
    }
}

.profile-filling .form-step {
    border-radius: 8px;
    background: #39393e;
    padding: 10px;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    gap: 12px;
    position: relative;
}

.profile-filling .form-step.active .step-body {
    display: block;
}

.profile-filling .rules {
    color: var(--white, #fbfbfb);
    font-family: Inter;
    font-size: 14px;
}

.profile-filling .rules .title {
    color: var(--white, #fbfbfb);
    font-family: Inter;
    font-size: 16px;
    font-style: normal;
    font-weight: 600;
    text-align: left;
    margin: 0;
}

.profile-filling h2 {
    color: #fbfbfb;
    font-size: 16px;
    font-weight: 600;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    gap: 8px;
}

.profile-filling h2 span {
    font-size: 16px;
    color: #252528;
    font-weight: 600;
    width: 32px;
    height: 32px;
    min-width: 32px;
    background-color: #fff;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    border-radius: 50%;
}

.profile-filling .form-group {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    gap: 16px;
}

.profile-filling .form-group .input-wrapper {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
}

.profile-filling .form-group .input-wrapper .error-text {
    color: #ff696f;
    font-family: Inter;
    font-size: 13px;
    margin-top: 6px;
}

.profile-filling .form-group label {
    margin-bottom: 8px;
    color: #fbfbfb;
    font-family: Inter;
    font-size: 14px;
    font-weight: 400;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    gap: 4px;
}

.profile-filling .form-group input,
.profile-filling .form-group textarea {
    border: none;
    border-bottom: 1px solid #bebfc0;
    resize: none;
    background-color: transparent;
    padding-bottom: 8px;
    color: var(--white, #fbfbfb);
    font-family: Inter;
    font-size: 16px;
}

.profile-filling .form-group input::-webkit-input-placeholder,
.profile-filling .form-group textarea::-webkit-input-placeholder {
    color: #bebfc0;
    font-size: 16px;
}

.profile-filling .form-group input::-moz-placeholder,
.profile-filling .form-group textarea::-moz-placeholder {
    color: #bebfc0;
    font-size: 16px;
}

.profile-filling .form-group input:-ms-input-placeholder,
.profile-filling .form-group textarea:-ms-input-placeholder {
    color: #bebfc0;
    font-size: 16px;
}

.profile-filling .form-group input::-ms-input-placeholder,
.profile-filling .form-group textarea::-ms-input-placeholder {
    color: #bebfc0;
    font-size: 16px;
}

.profile-filling .form-group input::placeholder,
.profile-filling .form-group textarea::placeholder {
    color: #bebfc0;
    font-size: 16px;
}

.profile-filling .form-group input textarea,
.profile-filling .form-group textarea textarea {
    overflow: visible;
}

.profile-filling .form-group input:focus,
.profile-filling .form-group textarea:focus {
    outline: none;
    border-bottom: 1px solid #b80006;
}

.profile-filling .form-group .rule {
    color: #dedfe1;
    font-size: 13px;
    margin-top: 8px;
}

.profile-filling .btn-group {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    gap: 8px;
    margin-top: 16px;
}

.profile-filling .btn-group .btn {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    gap: 8px;
}

.profile-filling .btn-group .btn .loader {
    animation: spin 1s linear infinite reverse;
}

.profile-filling .map {
    height: 320px;
    border-radius: 8px;
    overflow: hidden;
}

@media screen and (max-width: 1024px) {
    .profile-filling .map {
        height: 250px;
    }
}

.profile-filling .map iframe,
.profile-filling .map img {
    width: 100%;
    height: 100%;
    -o-object-fit: cover;
    object-fit: cover;
}

.profile-filling #nextBtn5 {
    display: none;
    margin: 0;
}

.profile-filling #nextBtn5.active {
    display: block;
}

.profile-filling #customButton1.active {
    display: none;
}

.profile-filling #customButton2 {
    display: none;
    background-color: transparent;
    border: 1px solid #fbfbfb;
    color: #fbfbfb;
    margin-top: 0;
}

.profile-filling #customButton2.active {
    display: block;
}

.profile-filling #customButton2:disabled {
    opacity: 0.5;
    cursor: no-drop;
}

.profile-filling #photoCount {
    display: none;
    color: #fbfbfb;
    font-size: 14px;
}

.profile-filling .photo-container {
    width: 100%;
    margin: auto;
    text-align: center;
}

.profile-filling .photo-container h5 {
    margin-top: 20px;
    font-size: 1.2em;
}

.profile-filling .photo-container p {
    color: #fbfbfb;
    text-align: center;
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 8px;
}

.profile-filling .photo-container p span {
    color: var(--white, #fbfbfb);
    text-align: center;
    font-size: 13px;
    font-weight: 300;
}

.profile-filling .photo-container input[type="file"] {
    display: none;
}

.profile-filling .photo-container #photos {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    gap: 8px;
    margin-top: 8px;
}

.profile-filling .photo-container img {
    width: 100%;
    height: 100%;
    max-height: 600px;
    min-height: 600px;
    border-radius: 8px;
    -o-object-fit: contain;
    object-fit: contain;
    position: relative;
    -o-object-fit: cover;
    object-fit: cover;
}

.profile-filling .photo-container .remove-photo {
    position: absolute;
    top: 0;
    left: 0;
    cursor: pointer;
    color: rgb(255, 255, 255);
    font-size: 20px;
    background: var(
        --Linear,
        linear-gradient(180deg, #7a0004 0%, #ba0007 100%)
    );
    width: 32px;
    height: 32px;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    padding-bottom: 3px;
    border-radius: 8px;
}

.profile-filling .move-button {
    cursor: pointer;
    position: absolute;
    top: 0;
    right: 0;
    width: 48px;
    height: 48px;
    border-radius: 8px;
    background: var(
        --Linear,
        linear-gradient(180deg, #7a0004 0%, #ba0007 100%)
    );
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    color: #fff;
}

.profile-filling .move-button.move-down {
    top: 60px;
}

.profile-filling .move-button:hover {
    background: -webkit-gradient(
        linear,
        left top,
        left bottom,
        from(#b00107),
        to(#ea020b)
    );
    background: linear-gradient(180deg, #b00107 0%, #ea020b 100%);
}

.profile-filling .text {
    font-size: 14px;
    color: #fbfbfb;
}

.profile-filling .request {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    gap: 8px;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    color: #fbfbfb;
    display: none;
}

.profile-filling .request .title {
    font-size: 16px;
    font-weight: 600;
}

.profile-filling .request .text {
    font-size: 14px;
}

.step-6 ol li {
    color: #fbfbfb;
    font-size: 14px;
}

.step-6 .verification-section label {
    color: #fbfbfb;
    font-size: 14px;
    font-weight: 700;
    line-height: normal;
    margin-bottom: 8px;
}

.step-6 .verification-section .btn-group {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    margin-top: 16px;
    gap: 16px;
}

.step-6 .image-card {
    height: 334px;
}

@media screen and (max-width: 1024px) {
    .step-6 .image-card {
        height: 219px;
    }
}

@media screen and (max-width: 768px) {
    .step-6 .image-card {
        height: 174px;
    }
}

.step-6 .image-card img {
    width: 100%;
    height: 100%;
    -o-object-fit: cover;
    object-fit: cover;
    -o-object-position: center;
    object-position: center;
}

.step-6 .custom-upload-btn {
    border-radius: 8px;
    border: 1px solid #fbfbfb;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    gap: 8px;
    padding: 12px 24px;
    background-color: transparent;
    color: #fbfbfb;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
}

.step-6 .custom-remove-btn {
    padding: 12px 24px;
    background-color: transparent;
    border-radius: 8px;
    border: 1px solid #fb7478;
    color: #fb7478;
    cursor: pointer;
    font-weight: 600;
}

.step-6 .custom-remove-btn,
.step-6 .custom-upload-btn {
    -webkit-transition: all 0.2s ease;
    transition: all 0.2s ease;
}

.step-6 .custom-remove-btn:hover,
.step-6 .custom-upload-btn:hover {
    opacity: 0.7;
}

.step-6 .user-info-section {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    gap: 16px;
}

.step-6 #skip {
    width: 128px;
    color: #000;
}

.noResults {
    height: 100%;
    width: 100%;
    position: absolute;
    left: 50%;
    top: 50%;
    -webkit-transform: translate(-50%, -50%);
    transform: translate(-50%, -50%);
}

.noResults .container {
    height: 100%;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    gap: 16px;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
}

.noResults .title {
    color: #fbfbfb;
    text-align: center;
    font-size: 24px;
    font-weight: 700;
}

.noResults .text {
    color: #fbfbfb;
    text-align: center;
    font-size: 16px;
}

.noResults img {
    width: 100%;
    max-width: 283px;
}

.section-404 {
    height: 100%;
    width: 100%;
    position: absolute;
    left: 50%;
    top: 50%;
    -webkit-transform: translate(-50%, -50%);
    transform: translate(-50%, -50%);
}

.section-404 .container {
    height: 100%;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    gap: 16px;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
}

.section-404 .title {
    color: #fbfbfb;
    text-align: center;
    font-size: 24px;
    font-weight: 700;
}

.section-404 img {
    width: 100%;
    max-width: 283px;
}

.subscribe {
    padding: 40px 0;
}

.subscribe .subscribe-card {
    border-radius: 12px;
    background: #39393e;
    padding: 24px;
    max-width: 503px;
    margin: 0 auto;
}

@media screen and (max-width: 1024px) {
    .subscribe .subscribe-card {
        padding: 16px;
    }
}

.subscribe .top {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-pack: justify;
    -ms-flex-pack: justify;
    justify-content: space-between;
    margin-bottom: 28px;
}

.subscribe .top .coins {
    margin: 0;
}

.subscribe .end-date,
.subscribe .renewal {
    color: #fff;
    text-align: center;
    font-size: 16px;
    font-weight: 500;
    margin: 12px 0;
}

.subscribe .end-date.none,
.subscribe .renewal.none {
    display: none;
}

.subscribe .subscribe-Btn.after {
    color: #877e7e;
    border-radius: 16px;
    background: -webkit-gradient(
        linear,
        left top,
        left bottom,
        from(#4c393a),
        to(#806062)
    );
    background: linear-gradient(180deg, #4c393a 0%, #806062 100%);
}

.subscribe .subscribe-Btn.after .sub-cost img {
    opacity: 0.6;
}

.subscribe .subscribe-Btn,
.subscribe .un-subscribe-Btn {
    background-color: #fff;
    position: relative;
    height: 130px;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    color: #fbfbfb;
    font-size: 40px;
    font-weight: 700;
    border-radius: 16px;
    overflow: hidden;
}

.subscribe .subscribe-Btn img,
.subscribe .un-subscribe-Btn img {
    position: absolute;
    top: 0;
    left: 0;
}

.subscribe .subscribe-Btn.load,
.subscribe .un-subscribe-Btn.load {
    color: #b95353 !important;
    pointer-events: none;
}

.subscribe .subscribe-Btn.load .loader,
.subscribe .un-subscribe-Btn.load .loader {
    display: block;
}

.subscribe .subscribe-Btn.load .sub-cost img,
.subscribe .un-subscribe-Btn.load .sub-cost img {
    opacity: 0.6;
}

.subscribe .subscribe-Btn .sub-cost,
.subscribe .un-subscribe-Btn .sub-cost {
    color: inherit;
    text-align: center;
    font-family: Inter;
    font-size: 16px;
    font-style: normal;
    font-weight: 500;
    line-height: normal;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    gap: 8px;
    margin-top: 8px;
}

.subscribe .subscribe-Btn .sub-cost img,
.subscribe .un-subscribe-Btn .sub-cost img {
    position: static;
}

.subscribe .subscribe-Btn .sub-cost span,
.subscribe .un-subscribe-Btn .sub-cost span {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    gap: 4px;
}

.subscribe .subscribe-Btn .loader,
.subscribe .un-subscribe-Btn .loader {
    position: absolute;
    top: 53%;
    left: 50%;
    width: 56px;
    height: 56px;
    -webkit-transform: translate(-50%, -50%);
    transform: translate(-50%, -50%);
    display: none;
}

.subscribe .subscribe-Btn .loader img,
.subscribe .un-subscribe-Btn .loader img {
    width: 100%;
    animation: spin 1s linear infinite reverse;
}

.subscribe .un-subscribe-Btn {
    background-color: #eaeaea;
    color: #7a0004;
}

.subscribe .un-subscribe-Btn.none {
    display: none;
}

.subscribe .terms ol {
    list-style: decimal;
    text-align: center;
    width: -webkit-fit-content;
    width: -moz-fit-content;
    width: fit-content;
    margin: 0 auto;
    color: var(--white, #fbfbfb);
    font-size: 14px;
}

.subscribe .title {
    text-align: center;
    font-family: Inter;
    font-size: 16px;
    font-style: normal;
    font-weight: 600;
    color: #fbfbfb;
    margin: 16px 0;
}

.subscribe .duposit-rules {
    text-align: center;
    font-size: 15px;
    font-weight: 500;
    background: var(
        --Linear,
        linear-gradient(180deg, #7a0004 0%, #ba0007 100%)
    );
    background-clip: text;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    margin: 12px auto;
    display: block;
}

.subscribe .cost {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    gap: 5px;
    color: #fbfbfb;
    font-size: 16px;
    font-weight: 600;
}

.coins-wrapper {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1000;
    background: rgba(15, 14, 14, 0.46);
    padding: 16px;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    display: none;
}

.coins-wrapper.active {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
}

.coins-wrapper .coins-popup {
    border-radius: 16px;
    background: #39393e;
    padding: 24px;
    max-width: 400px;
    width: 100%;
    position: relative;
}

.coins-wrapper .close {
    position: absolute;
    top: 11px;
    right: 11px;
    cursor: pointer;
}

.coins-wrapper .title {
    color: var(--white, #fbfbfb);
    text-align: center;
    font-size: 24px;
    font-weight: 600;
    margin-bottom: 16px;
}

.coins-wrapper .repaymant-list {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    gap: 24px;
}

@media screen and (max-width: 768px) {
    .coins-wrapper .repaymant-list {
        gap: 16px;
    }
}

.coins-wrapper .repaymant-item {
    width: calc((100% - 24px) / 2);
    border-radius: 8px;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    padding: 24px 16px;
    -webkit-transition: all 0.2s linear;
    transition: all 0.2s linear;
    cursor: pointer;
}

.coins-wrapper .repaymant-item:hover {
    -webkit-transform: scale(1.02);
    transform: scale(1.02);
}

@media screen and (max-width: 768px) {
    .coins-wrapper .repaymant-item {
        width: calc((100% - 16px) / 2);
    }
}

.coins-wrapper .coins {
    color: #ffab03;
    font-size: 32px;
    font-weight: 600;
    margin: 0;
    padding-bottom: 16px;
    border-bottom: 1px solid #ba0007;
    width: 100%;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
}

.coins-wrapper .cost {
    color: #fbfbfb;
    font-size: 20px;
    font-weight: 600;
    padding-top: 16px;
}

.deposit-types {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    -webkit-box-pack: justify;
    -ms-flex-pack: justify;
    justify-content: space-between;
    max-width: 340px;
    margin: 0 auto;
    gap: 12px;
}

.deposit-type,
.referral-out {
    width: calc((100% - 24px) / 3);
    height: 87px;
    border-radius: 8px;
    background: var(
        --Linear,
        linear-gradient(180deg, #7a0004 0%, #ba0007 100%)
    );
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    gap: 8px;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    font-size: 14px;
    font-style: normal;
    font-weight: 600;
    color: #fbfbfb;
    cursor: pointer;
    -webkit-transition: all 0.2s linear;
    transition: all 0.2s linear;
}

.deposit-type:hover,
.referral-out:hover {
    -webkit-transform: translateY(-5px);
    transform: translateY(-5px);
    outline: 1px solid #fff;
}

.open-transaction {
    cursor: pointer;
    font-size: 16px;
    font-style: normal;
    font-weight: 500;
    background: var(
        --Linear,
        linear-gradient(180deg, #7a0004 0%, #ba0007 100%)
    );
    background-clip: text;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    gap: 4px;
}

.open-transaction img {
    animation: spin 1s linear infinite reverse;
}

.deposit-wrapper {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1000;
    background: rgba(15, 14, 14, 0.46);
    padding: 16px;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    display: none;
}

.deposit-wrapper.active {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
}

.deposit-wrapper .message {
    position: fixed;
    left: 20px;
    bottom: 80px;
    z-index: 1001;
    padding: 8px;
    border-radius: 8px;
    background: #525252;
    color: white;
    font-size: 16px;
    font-weight: 500;
    display: none;
}

.deposit-wrapper .message .message-body {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    gap: 8px;
}

.deposit-wrapper .message img {
    width: 16px;
}

.deposit-wrapper .deposit-popup {
    border-radius: 16px;
    background: #39393e;
    padding: 24px;
    width: 100%;
    max-width: 343px;
    position: relative;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    gap: 16px;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
}

.deposit-wrapper .close {
    position: absolute;
    top: 8px;
    right: 8px;
    cursor: pointer;
}

.deposit-wrapper .title {
    color: var(--white, #fbfbfb);
    text-align: center;
    font-size: 16px;
    font-style: normal;
    font-weight: 600;
}

.deposit-wrapper .deposit-info {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    gap: 8px;
    text-align: center;
}

.deposit-wrapper .course {
    color: #fbfbfb;
    font-size: 14px;
    font-style: normal;
    font-weight: 400;
}

.deposit-wrapper .key {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-pack: justify;
    -ms-flex-pack: justify;
    justify-content: space-between;
    gap: 16px;
}

.deposit-wrapper .key span {
    border-radius: 8px;
    background: #525252;
    padding: 8px;
}

.deposit-wrapper .copy {
    cursor: pointer;
}

.transaction-wrapper {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1000;
    background: rgba(15, 14, 14, 0.46);
    padding: 16px;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    display: none;
}

.transaction-wrapper.active {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
}

.transaction-wrapper .transaction-popup {
    border-radius: 12px;
    background: #39393e;
    padding: 24px;
    width: 100%;
    max-width: 860px;
}

@media screen and (max-width: 768px) {
    .transaction-wrapper .transaction-popup {
        padding: 12px;
    }
}

.transaction-wrapper .top {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-pack: justify;
    -ms-flex-pack: justify;
    justify-content: space-between;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    margin-bottom: 24px;
}

.transaction-wrapper .title {
    color: #fbfbfb;
    font-size: 20px;
    font-weight: 500;
}

.transaction-wrapper .close {
    cursor: pointer;
}

.transaction-wrapper .transactions {
    max-height: 300px;
    overflow: auto;
    padding-right: 12px;
}

@media screen and (max-width: 768px) {
    .transaction-wrapper .transactions {
        padding: 5px;
    }
}

.transaction-wrapper .transactions::-webkit-scrollbar {
    background-color: transparent;
    width: 2px;
}

.transaction-wrapper .transactions::-webkit-scrollbar-thumb {
    background: var(
        --Linear,
        linear-gradient(180deg, #7a0004 0%, #ba0007 100%)
    );
}

.transaction-wrapper .transactions::-webkit-scrollbar-track {
    background: #525252;
}

.transaction-wrapper .transaction-table {
    width: 100%;
    color: #fbfbfb;
}

.transaction-wrapper thead tr {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    gap: 4px;
    border-bottom: 1px solid #525252;
    padding-bottom: 12px;
}

.transaction-wrapper thead th {
    width: 100%;
    text-align: left;
    font-size: 14px;
    font-weight: 400;
}

.transaction-wrapper .transaction-item {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    gap: 4px;
    padding: 12px 0;
}

.transaction-wrapper .transaction-item:not(:last-child) {
    border-bottom: 1px solid #525252;
}

.transaction-wrapper .transaction-item td {
    width: 100%;
    font-size: 16px;
    font-style: normal;
    font-weight: 300;
}

@media screen and (max-width: 768px) {
    .transaction-wrapper .transaction-item td {
        font-size: 14px;
    }
}

.statistic-list {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    gap: 12px;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
}

.statistic-list .statistic-item {
    color: #fbfbfb;
    font-size: 16px;
}

.statistic-list .statistic-item span {
    color: #bebfc0;
    text-align: center;
    font-size: 16px;
}

.refferals {
    padding: 40px 0;
}

.refferals .refferals-card {
    border-radius: 16px;
    background: #39393e;
    max-width: 720px;
    padding: 24px;
    margin: 0 auto;
}

@media screen and (max-width: 1024px) {
    .refferals .refferals-card {
        padding: 16px;
    }
}

.refferals .top {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: justify;
    -ms-flex-pack: justify;
    justify-content: space-between;
    margin-bottom: 24px;
}

.refferals .coins {
    margin: 0;
}

.refferals .statistic {
    margin-bottom: 32px;
}

.refferals .statistic .title {
    margin-bottom: 12px;
}

.refferals .title {
    color: #fbfbfb;
    text-align: center;
    font-size: 16px;
    font-style: normal;
    font-weight: 600;
    margin-bottom: 12px;
}

.refferals .sub-link .title {
    max-width: 270px;
    margin: 0 auto;
    margin-bottom: 16px;
    line-height: 151%;
}

.refferals .sub-link .title span {
    padding: 4px 8px;
    border-radius: 4px;
    background: -webkit-gradient(
        linear,
        left top,
        left bottom,
        color-stop(-29.63%, #ffe603),
        to(#d80957)
    );
    background: linear-gradient(180deg, #ffe603 -29.63%, #d80957 100%);
    margin: 0 4px;
}

.refferals .link-body {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    max-width: 450px;
    margin: 0 auto;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    gap: 8px;
    margin-bottom: 16px;
}

.refferals .link-body .link {
    border-radius: 8px;
    background: #525252;
    height: 39px;
    color: #fff;
    text-align: center;
    font-family: Inter;
    font-size: 16px;
    font-style: normal;
    font-weight: 400;
    width: 100%;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    padding: 0 14px;
}

.refferals .link-body .btn {
    display: block;
}

.refferals .link-body .message {
    position: fixed;
    left: 20px;
    bottom: 80px;
    z-index: 1001;
    padding: 8px;
    border-radius: 8px;
    background: #525252;
    color: white;
    font-size: 16px;
    font-weight: 500;
    display: none;
}

.refferals .link-body .message div {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    gap: 8px;
}

.refferals .link-body .message img {
    width: 16px;
}

.refferals .earn {
    max-width: 155px;
    margin: 0 auto;
    margin-bottom: 32px;
}

.refferals .btn {
    display: block;
}

.refferals .deposit {
    margin-bottom: 32px;
}

.refferals .referal-table {
    width: 100%;
}

.refferals .referal-table tbody {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    gap: 12px;
}

.refferals .referal-table thead tr {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-pack: justify;
    -ms-flex-pack: justify;
    justify-content: space-between;
    margin-bottom: 12px;
}

.refferals .referal-table thead th {
    width: 33.33%;
    color: #fbfbfb;
    font-size: 16px;
    font-style: normal;
    font-weight: 500;
}

.refferals .referal-table thead th:first-child {
    text-align: left;
}

.refferals .referal-table thead th:last-child {
    text-align: right;
}

.refferals .referal-item {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    width: 100%;
}

.refferals .referal-item td {
    text-align: center;
    width: 33.33%;
    color: #fbfbfb;
    font-size: 16px;
    font-weight: 300;
}

.refferals .referal-item td:first-child {
    text-align: left;
}

.refferals .referal-item td:last-child {
    text-align: right;
}

.load-more {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    margin-top: 32px;
    gap: 12px;
    color: #fbfbfb;
    cursor: default;
}

.load-more img {
    cursor: pointer;
}

.settings {
    padding-top: 80px;
}

.settings .container {
    max-width: 1010px;
}

.settings .title {
    color: var(--white, #fbfbfb);
    font-family: Inter;
    font-size: 24px;
    font-style: normal;
    font-weight: 700;
    margin-bottom: 24px;
}

.settings .settings-list {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    width: 100%;
    gap: 40px;
    margin: 0 auto;
}

@media screen and (max-width: 768px) {
    .settings .settings-list {
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
        gap: 24px;
    }
}

.settings .settings-item {
    border-radius: 8px;
    background: #39393e;
    padding: 32px;
    width: 50%;
}

@media screen and (max-width: 768px) {
    .settings .settings-item {
        padding: 16px;
        width: 100%;
    }
    .settings .settings-item img {
        width: 20px;
    }
}

.settings .current {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: end;
    -ms-flex-align: end;
    align-items: flex-end;
    color: var(--white, #fbfbfb);
    text-align: center;
    font-family: Inter;
    font-size: 16px;
    border-bottom: 1px solid #bebfc0;
    padding-bottom: 16px;
    gap: 24px;
    margin-bottom: 12px;
}

@media screen and (max-width: 768px) {
    .settings .current {
        gap: 12px;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
    }
}

.settings-wrapper {
    position: fixed;
    background: rgba(22, 21, 21, 0.51);
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1000;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
}

.settings-wrapper .card {
    border-radius: 8px;
    background: #525252;
    padding: 24px;
}

.faq {
    min-height: 80vh;
    padding: 30px 0;
    position: relative;
}

.faq .container {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    gap: 16px;
    max-width: 1390px;
    position: relative;
}

@media screen and (max-width: 768px) {
    .faq .container {
        display: block;
    }
}

.faq .sidebar {
    height: -webkit-fit-content;
    height: -moz-fit-content;
    height: fit-content;
    position: sticky;
    top: 130px;
    width: 25%;
    -webkit-transition: all 0.2s linear;
    transition: all 0.2s linear;
}

.faq .sidebar .title {
    margin-bottom: 24px;
}

@media screen and (max-width: 768px) {
    .faq .sidebar .title {
        display: none;
    }
}

.faq .sidebar .open-faq {
    margin-bottom: 24px;
    display: none;
}

@media screen and (max-width: 768px) {
    .faq .sidebar .open-faq {
        display: block;
    }
}

@media screen and (max-width: 1024px) {
    .faq .sidebar {
        width: 30%;
    }
}

@media screen and (max-width: 768px) {
    .faq .sidebar {
        position: fixed;
        left: 100%;
        background: #252528;
        padding: 16px;
        z-index: 100;
        top: 105px;
        height: 100%;
        width: 100%;
    }
    .faq .sidebar.open {
        left: 0;
    }
}

.faq .title {
    color: #fff;
    font-size: 20px;
    font-style: normal;
    font-weight: 600;
    line-height: normal;
}

.faq .sidebar-menu {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    gap: 12px;
    max-width: 250px;
    max-height: 70vh;
    overflow: auto;
    padding-right: 10px;
}

@media screen and (max-width: 768px) {
    .faq .sidebar-menu {
        max-width: 100%;
        padding: 0;
    }
}

.faq .sidebar-menu::-webkit-scrollbar {
    background-color: transparent;
    width: 2px;
}

.faq .sidebar-menu::-webkit-scrollbar-thumb {
    background: var(
        --Linear,
        linear-gradient(180deg, #7a0004 0%, #ba0007 100%)
    );
}

.faq .sidebar-menu::-webkit-scrollbar-track {
    background: #424242;
}

.faq .sidebar-menu-item {
    padding: 8px;
    cursor: pointer;
    color: #fff;
    font-size: 16px;
    position: relative;
    border-radius: 8px;
    font-weight: 500;
}

.faq .sidebar-menu-item svg {
    position: absolute;
    right: 13px;
    top: 15px;
}

.faq .sidebar-menu-item:hover {
    color: #f8cccc;
}

.faq .sidebar-menu-item.open {
    background-color: #fff;
    color: #7a0004;
}

.faq .accordion p {
    padding: 8px;
    margin-left: -8px;
    font-weight: 500;
    border-radius: 8px;
    -webkit-transition: all 0.2s linear;
    transition: all 0.2s linear;
}

.faq .accordion.active svg {
    -webkit-transform: rotate(-180deg);
    transform: rotate(-180deg);
}

.faq .accordion.open {
    background-color: transparent;
}

.faq .accordion.open p {
    background-color: #fff;
    color: #7a0004;
}

.faq .accordion.open path {
    fill: #7a0004;
}

.faq .accordion .accordion-pannel {
    margin-top: 12px;
    padding-left: 16px;
    border-left: 1px solid #686878;
    display: none;
}

.faq .accordion .accordion-item {
    color: #fff;
    font-size: 16px;
}

.faq .accordion .accordion-item:not(:last-child) {
    margin-bottom: 12px;
}

.faq .accordion .accordion-item:hover {
    color: #f8cccc;
}

.faq .accordion .accordion-item.open {
    color: #b53838;
}

.faq .main {
    width: 75%;
    position: relative;
}

@media screen and (max-width: 1024px) {
    .faq .main {
        width: 70%;
    }
}

@media screen and (max-width: 768px) {
    .faq .main {
        width: 100%;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
    }
}

.faq .main .open-faq {
    position: sticky;
    margin-bottom: 20px;
    z-index: 10;
    background-color: #252528;
    display: none;
}

@media screen and (max-width: 768px) {
    .faq .main .open-faq {
        display: block;
    }
}

.faq .top {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-pack: end;
    -ms-flex-pack: end;
    justify-content: flex-end;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    gap: 24px;
}

@media screen and (max-width: 768px) {
    .faq .top {
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
    }
}

.faq .search-wrapper {
    width: 100%;
    max-width: 793px;
    position: relative;
}

.faq .search-wrapper .input-wrapper {
    position: relative;
}

.faq .search-wrapper .input-wrapper img {
    position: absolute;
    left: 12px;
    top: 50%;
    -webkit-transform: translateY(-50%);
    transform: translateY(-50%);
    width: 17px;
}

.faq .search-wrapper .input-wrapper .search-input {
    padding: 8px 12px 8px 36px;
    border-radius: 8px;
    background: #525252;
    width: 100%;
    color: #fbfbfb;
    height: 40px;
}

.faq .search-wrapper .input-wrapper .search-input:focus {
    outline: 1px solid rgba(193, 0, 0, 0);
}

.faq .search-wrapper .result-wrapper {
    border-radius: 0px 0px 8px 8px;
    max-height: 300px;
    overflow: hidden;
    background: #525252;
    position: absolute;
    top: 88%;
    width: 100%;
}

.faq .search-wrapper .search-result {
    border-radius: 0px 0px 8px 8px;
    max-height: 300px;
    overflow: auto;
}

.faq .search-wrapper .search-result::-webkit-scrollbar {
    background-color: transparent;
    width: 4px;
}

.faq .search-wrapper .search-result::-webkit-scrollbar-thumb {
    background: var(
        --Linear,
        linear-gradient(180deg, #7a0004 0%, #ba0007 100%)
    );
}

.faq .search-wrapper .search-result::-webkit-scrollbar-track {
    background: #888888;
}

.faq .search-wrapper .result-item {
    padding: 12px;
    color: #fff;
    font-size: 16px;
    font-weight: 400;
    cursor: pointer;
}

.faq .search-wrapper .result-item:hover {
    background-color: rgba(0, 0, 0, 0.1647058824);
}

.faq .search-wrapper .result-item:first-child {
    border-top: 2px solid #313131;
}

.faq .search-wrapper .result-item span {
    color: rgb(237, 1, 1);
}

.faq .search-wrapper .result-item:not(:last-child) {
    border-bottom: 1px solid #616166;
}

.faq .faq-content {
    display: none;
    margin-top: 24px;
}

.faq .faq-content h2 {
    color: #eaeff3;
    font-size: 20px;
    margin-bottom: 12px;
}

.faq .faq-content p {
    color: #eaeff3;
    font-size: 16px;
    line-height: 120%;
    font-weight: 300;
}

.faq .faq-navigation {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    gap: 16px;
    margin-top: 50px;
}

.faq .faq-navigation .faq-next,
.faq .faq-navigation .faq-prev {
    width: 56px;
    height: 56px;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    border-radius: 8px;
    cursor: pointer;
}

@media screen and (max-width: 768px) {
    .faq .faq-navigation {
        -webkit-box-pack: justify;
        -ms-flex-pack: justify;
        justify-content: space-between;
        margin-top: 24px;
    }
}

.unsubcribe-wrapper {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1000;
    background: rgba(15, 14, 14, 0.46);
    padding: 16px;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    display: none;
}

.unsubcribe-wrapper.active {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
}

.unsubcribe-wrapper .unsubcribe-card {
    border-radius: 8px;
    background: #39393e;
    max-width: 350px;
    padding: 24px;
    position: relative;
}

.unsubcribe-wrapper .close {
    position: absolute;
    top: 6px;
    right: 6px;
    cursor: pointer;
}

.unsubcribe-wrapper .text {
    margin-bottom: 16px;
    text-align: center;
    font-weight: 500;
    font-size: 16px;
    color: #fbfbfb;
}

.referral-out-wrapper {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1000;
    background: rgba(15, 14, 14, 0.46);
    padding: 16px;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    display: none;
}

.referral-out-wrapper.active {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
}

.referral-out-wrapper .card {
    border-radius: 8px;
    background: #39393e;
    max-width: 350px;
    padding: 24px;
    padding-top: 30px;
    position: relative;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    gap: 12px;
    width: 100%;
    max-width: 430px;
    display: none;
}

@media screen and (max-width: 768px) {
    .referral-out-wrapper .card {
        padding: 16px;
    }
}

.referral-out-wrapper .card.active {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
}

.referral-out-wrapper .card input {
    border-radius: 8px;
    background: #525252;
    width: 100%;
    padding: 8px;
    font-size: 16px;
    color: #fff;
}

.referral-out-wrapper .card input::-webkit-input-placeholder {
    color: #bebfc0;
    font-size: 16px;
    font-weight: 400;
}

.referral-out-wrapper .card input::-moz-placeholder {
    color: #bebfc0;
    font-size: 16px;
    font-weight: 400;
}

.referral-out-wrapper .card input:-ms-input-placeholder {
    color: #bebfc0;
    font-size: 16px;
    font-weight: 400;
}

.referral-out-wrapper .card input::-ms-input-placeholder {
    color: #bebfc0;
    font-size: 16px;
    font-weight: 400;
}

.referral-out-wrapper .card input::placeholder {
    color: #bebfc0;
    font-size: 16px;
    font-weight: 400;
}

.referral-out-wrapper .close {
    position: absolute;
    top: 8px;
    right: 8px;
    cursor: pointer;
}

.referral-out-wrapper .title {
    color: #fbfbfb;
    text-align: center;
    font-size: 16px;
    font-weight: 600;
}

.referral-out-wrapper .network-icon {
    width: 56px;
    margin: 0 auto;
}

.referral-out-wrapper .crypto-address-input div {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    gap: 16px;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
}

.referral-out-wrapper .paste {
    cursor: pointer;
}

.referral-out-wrapper .paste:hover {
    opacity: 0.7;
}

.referral-out-wrapper .referral-out-navigation {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    gap: 12px;
}

.referral-out-wrapper .referral-out-navigation .back,
.referral-out-wrapper .referral-out-navigation .next {
    width: 50%;
}

.referral-out-wrapper .crypto-rate {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    gap: 8px;
    color: #fff;
}

.referral-out-wrapper .amount-input {
    position: relative;
}

.referral-out-wrapper .error input {
    border-radius: 8px;
    background: #7d5050;
}

.referral-out-wrapper .error .error-text {
    display: block;
}

.referral-out-wrapper .error-text {
    margin-top: 8px;
    color: #fb4444;
    font-family: Inter;
    font-size: 14px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;
    display: none;
}

.referral-out-wrapper .amount-input input {
    padding-left: 35px;
    color: #fc8f1b;
    height: 40px;
}

.referral-out-wrapper .amount-input .input-label {
    position: absolute;
    top: 9px;
    left: 8px;
}

.referral-out-wrapper .details-list {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    gap: 12px;
}

.referral-out-wrapper .datails-item {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    color: var(--white, #fbfbfb);
    font-family: Inter;
    font-size: 14px;
}

.referral-out-wrapper .datails-item span {
    color: #bebfc0;
    text-align: center;
    font-size: 14px;
    font-weight: 600;
    white-space: nowrap;
    margin-right: 8px;
}

.center {
    display: flex;
}

.loading {
    position: absolute;
    z-index: 1000;
    padding: 0;
    margin: 0;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.509);
    animation-name: loading;
    animation-duration: 1s;
    animation-iteration-count: infinite;
    border-radius: 16px;
}

@keyframes loading {
    50% {
        background: #ffe6f280;
    }
}

.verification-container {
    position: relative;
}

.resetPassword-card.card {
    border-radius: 16px !important;
}

#map {
    height: 219px;
}

.advertising-wrapper.show {
    display: -webkit-box !important;
    display: -ms-flexbox !important;
    display: flex !important;
}

.users .user-image .likes .btn.active {
    background: #fff !important;
}

.users .user-image .likes .btn.active path {
    fill: rgb(164, 0, 0);
}

.profile .left-side .head-porfile .img-card .likes .btn.active {
    background: #fff !important;
}

.profile .left-side .head-porfile .img-card .likes .btn.active path {
    fill: rgb(164, 0, 0);
}

.step-body {
    display: none;
}

.profile-filling #customButton2 {
    display: flex !important;
}

.profile-filling #nextBtn5 {
    display: block !important;
}

.profile-filling #photoCount {
    display: block !important;
}

#header.open {
    overflow: visible !important;
}

.none {
    display: none !important;
}

.edit .step-body {
    display: block !important;
}

.delete-wrapper {
    padding: 16px;
    position: fixed;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    z-index: 10000;
    background: rgba(37, 37, 40, 0.43);
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    display: none;
}

.delete-wrapper.active {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
}

.delete-wrapper .delete-popup {
    border-radius: 8px;
    background: #39393e;
    padding: 24px;
    max-width: 427px;
}

.delete-wrapper .title {
    color: #fbfbfb;
    text-align: center;
    font-size: 20px;
    font-weight: 600;
    margin-bottom: 24px;
}

.delete-wrapper .btn-group {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    gap: 8px;
}

.delete-wrapper .btn {
    width: 50%;
}

.delete-wrapper .white {
    color: #000;
}

#confirm-delete {
    display: flex;
    gap: 10px;
}

#confirm-delete .loader {
    display: none;
    animation: spin 1s linear infinite reverse;
}

#confirm-delete.load .loader {
    display: block !important;
}

.res-succes-send .btn,
.pass-succes .btn {
    display: inline-block;
    width: 100%;
    margin-top: 10px;
}

.profile .info-group.pending:before {
    z-index: 400;
}

.text-error {
    color: #ff5959;
    font-family: Inter;
    font-size: 13px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;
    text-align: center;
    margin-top: 15px;
    display: none;
}

.text-error.show {
    display: block;
}

.form-error {
    color: #ff5959;
    font-family: Inter;
    font-size: 13px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;
    margin-top: 6px;
}

select#gender {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    background-color: transparent;
    color: #fbfbfb;
    border: none;
    font-size: 16px;
    font-weight: 400;
    line-height: normal;
    background-image: url("../img/select.svg");
    background-repeat: no-repeat;
    background-position: right 0.3rem top 50%;
    background-size: 0.99rem auto;
    background-color: #39393e;
    border-radius: 8px;
    border: 1px solid #525252;
    padding: 12px;
    width: 100%;
}

.un-subscribe-Btn.after {
    color: #877e7e;
    border-radius: 16px;
    background: -webkit-gradient(
        linear,
        left top,
        left bottom,
        from(#4c393a),
        to(#806062)
    );
    background: linear-gradient(180deg, #4c393a 0%, #806062 100%);
}

.key .title {
    max-width: 240px;
    overflow: hidden;
    text-overflow: ellipsis;
}

</style>