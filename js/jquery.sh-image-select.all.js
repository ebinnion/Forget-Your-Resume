/*! jQuery SH Image Select Drop-down v1.0, Copyright 2012 Alexy Vauch! */
(function($) {
    /**
     * Creates a drop-down list of images for all matched elements.
     *
     * @example $("#select").shImageSelectDropdown();
     * @input "data-image" attribute with image link value required. Ex: <option data-image="image.jpg">image</option>
     *
     * @method shImageSelectDropdown
     * @return $
     * @param o {Object} A set of configuration properties (key/value pairs).
     */
    $.fn.shImageSelectDropdown = function (o){
        var defaults = {
                theme: 'arrows', // Theme name
                expandDirection: 'down', // The direction of the image list expanding
                dropdownEffect: { // Allowed values: "fade", "horizontal-expand", "vertical-expand", "expand".
                    open: '',
                    close: ''
                },
                easing: {  // A string indicating which easing function to use for the transition.
                    open: '',
                    close: ''
                },
                showText: true, // Show select option text over image? // Allowed values: true, false.
                animationSpeed: {
                    open: 0,  // Animation speed on opening drop-down list (in milliseconds).
                    close: 0 // Animation speed on closing drop-down list (in milliseconds).
                },
                imageLimit: 3, // Limits the maximum number of visible images. "0" - Unlim.
                additionalClass: '', // Name of additional plugin html container css class.
                skin: 'light', // Skin name. Allowed values: "light", "dark"
                callbacks: { // Callback functions
                    onOpen: '',
                    onClose: '',
                    onSelect: ''
                }
            },
            options;

        options = $.extend(true, defaults, o);

        return this.each(function() {
            $(this).data('sh-image-select-dropdown', new shImageSelectDropdown($(this), options, function (scrollbarOptions){
                $(this).shScrollbar(scrollbarOptions);
            }));
        });
    };

    /**
     * @constructor
     * @class shImageSelectDropdown
     * @param element {HTMLElement} The element to create the image drop-down for.
     * @param options {Object} A set of configuration properties (key/value pairs).
     * @param scrollbar function within shScrollbar plugin initialization.
     */
    var shImageSelectDropdown = function (element, options, scrollbar){
        var self = this;

        this.container = $('<div></div>').addClass('sh-img-dropdown-container');
        this.selectBox = $('<div></div>').addClass('sh-img-dropdown-box');
        this.selectBoxOverlay = $('<div></div>').addClass('sh-img-dropdown-box-overlay');
        this.underOverlayLayer = $('<div></div>').addClass('sh-img-dropdown-under-overlay');
        this.list = $('<div></div>').addClass('sh-img-dropdown-list');
        this.listContainer = $('<div></div>').addClass('sh-img-dropdown-list-container');
        this.listScreen = $('<div></div>').addClass('sh-img-dropdown-list-screen');

        /**
         * Opens image list.
         *
         * @method open
         * @return undefined
         */
        this.open = function (){
            animateDropdown(effects.currentEffect.open, options.animationSpeed.open, easingEffect.onOpen, options.callbacks.onOpen);
        };

        /**
         * Closes image list.
         *
         * @method close
         * @return undefined
         */
        this.close = function (){
            animateDropdown(effects.currentEffect.close, options.animationSpeed.close, easingEffect.onClose, options.callbacks.onClose);
        };

        /**
         * Selects image.
         *
         * @method select
         * @return undefined
         */
        this.select = function (image){
            element.children().removeAttr('selected').filter('[class="' + image.attr('id') + '"]').attr('selected', 'selected');
            element.triggerHandler('change');

            setSelectedImage(image, options.callbacks.onSelect);
        };

        var eventHandlers = {
            dragged: false,

            showImageText: function (){
                $(this).children('img').stop().fadeTo(300, 0.6);

                if(options.showText) {
                    $(this).children('.sh-img-dropdown-textblock').stop().animate({
                        bottom: '5px'
                    }, 'fast');
                }
            },

            hideImageText: function (){
                $(this).children('img').stop().fadeTo(300, 1);

                if(options.showText) {
                    $(this).children('.sh-img-dropdown-textblock').stop().animate({
                        bottom: '-100%'
                    }, 'fast');
                }
            },

            mouseImageSelect: function (){
                self.select($(this).css('opacity', 1));
                self.close();
            },

            touchImageSelect: function (e){
                var image = $(this);

                eventHandlers.dragged = false;

                setTimeout(function (){
                    if (eventHandlers.dragged) {
                        return;
                    }

                    self.select(image.css('opacity', 1));
                    self.close();

                }, 300);

                e.preventDefault();
            },

            touchDragging: function (){
                eventHandlers.dragged = true;
            },

            toggleDropDownVisibility: function (){
                self.listContainer.is(':hidden') ? self.open() : self.close();
            }
        },

        animateDropdown = function (effect, speed, easing, callback){
            self.listContainer.stop().animate(effect, speed, easing, function (){
                $.shHelper.callCallback(callback, self.container);
            });
        },

        setSelectedImage = function (newImage, callback){
            self.selectBox.empty().prepend(newImage.clone());

            if(callback) {
                $.shHelper.callCallback(callback, self.container);
            }
        },

        expansion = (function (){
            var expandDirection = options.expandDirection,
                cssClass = 'sh-img-dropdown-direction-',
                effect = 'vertical-expand',
                scrollbarAxis = 'y',
                expandSize = 'height',
                extraWidth = false,
                containerOffset = {};

            switch (options.expandDirection) {
                case 'down':
                default:
                    cssClass += expandDirection;
                    extraWidth = true;
                    break;

                case 'up':
                    cssClass += expandDirection;
                    extraWidth = true;
                    containerOffset = {
                        open: {
                            'margin-top': '-100%'
                        },
                        close: {
                            'margin-top': '0'
                        }
                    };
                    break;

                case 'right':
                    cssClass += expandDirection;
                    expandSize = 'width';
                    scrollbarAxis = 'x';
                    effect = 'horizontal-expand';
                    break;

                case 'left':
                    cssClass += expandDirection;
                    expandSize = 'width';
                    scrollbarAxis = 'x';
                    containerOffset = {
                        open: {
                            'margin-left': '-100%'
                        },
                        close: {
                            'margin-left': '0'
                        }
                    };

                    effect = 'horizontal-expand';
                    break;

                case 'left-right':
                    cssClass += expandDirection;
                    expandSize = 'width';
                    scrollbarAxis = 'x';
                    containerOffset = {
                        open: {
                            'margin-left': '-50%'
                        },
                        close: {
                            'margin-left': '0'
                        }
                    };

                    effect = 'horizontal-expand';
                    break;

                case 'up-down':
                    cssClass += expandDirection;
                    extraWidth = true;
                    containerOffset = {
                        open: {
                            'margin-top': '-50%'
                        },
                        close: {
                            'margin-top': '0'
                        }
                    };
                    break;
            }

            return {
                cssClass: cssClass,
                effect: effect,
                scrollbarAxis: scrollbarAxis,
                expandSize: expandSize,
                extraWidth: extraWidth,
                containerOffset: containerOffset
            };
        })(),

        theme = (function (){
            var themeName = options.theme,
                cssClass = 'sh-img-dropdown-theme-',
                events = {},
                elements = [];

            switch (themeName) {
                case 'minimal':
                    cssClass += themeName;
                    events = {
                        mouseover: {
                            element: self.selectBoxOverlay,
                            handler: function (){
                                self.underOverlayLayer.stop().fadeTo(300, 1);
                            }
                        },

                        mouseout: {
                            element: self.selectBoxOverlay,
                            handler: function (){
                                self.underOverlayLayer.stop().fadeOut();
                            }
                        }
                    };

                    elements.push({
                        container: self.container,
                        element: $('<div></div>').addClass(cssClass + '-arrow')
                    });
                    break;

                case 'arrows':
                default:
                    cssClass += themeName;
                    break;
            }

            return {
                cssClass: cssClass,
                events: events,
                elements: elements
            };
        })(),

        skin = (function (){
            var skinName = options.skin,
                cssClass = 'sh-img-dropdown-',
                scrollbarSkin = 'light';

            switch (skinName) {
                case 'dark':
                    cssClass += skinName;
                    scrollbarSkin = 'dark';
                    break;

                case 'light':
                default:
                    cssClass += skinName;
                    break;
            }

            return {
                cssClass: cssClass,
                scrollbarSkin: scrollbarSkin
            };
        })(),

        effects = (function (){
            var animationEffects = {
                    expand: {
                        open: {
                            height: 'show',
                            width: 'show'
                        },
                        close: {
                            height: 'hide',
                            width: 'hide'
                        }
                    },
                    'vertical-expand': {
                        open: {
                            height: 'show'
                        },
                        close: {
                            height: 'hide'
                        }
                    },
                    'horizontal-expand': {
                        open: {
                            width: 'show'
                        },
                        close: {
                            width: 'hide'
                        }
                    },
                    fade: {
                        open: {
                            opacity: 'show'
                        },
                        close: {
                            opacity: 'hide'
                        }
                    }
                },

                effectsObject = {
                    currentEffect: {},

                    effectExists: function (effectName){
                        if (typeof effectName === 'string' && effectName in animationEffects) {
                            return true;
                        }

                        return false;
                    },

                    getDefaultEffectProps: function (){
                        return animationEffects['vertical-expand'];
                    },

                    getEffectProps: function (effectName){
                        var currentEffectProps = false;

                        if (this.effectExists(effectName)) {
                            currentEffectProps = animationEffects[effectName];
                        }

                        return currentEffectProps;
                    },

                    getEffectPropsFromObj: function (effectObj){
                        var methods = this,
                            readyEffect = {};

                        $.each(effectObj, function (event, effectProp){
                            if (typeof effectProp === 'object') {
                                readyEffect[event] = effectProp;

                            } else if(methods.effectExists(effectProp)) {
                                readyEffect[event] = methods.getEffectProps(effectProp)[event];
                            }
                        });

                        return readyEffect;
                    },

                    pushEffect: function (effect){
                        var readyEffect = {},
                            effectProps;

                        if (typeof effect === 'string') {
                            if (this.effectExists(effect)) {
                                effectProps = this.getEffectProps(effect);

                                readyEffect['open'] = effectProps.open;
                                readyEffect['close'] = effectProps.close;
                            }

                        } else if (typeof effect === 'object') {
                            readyEffect = this.getEffectPropsFromObj(effect);
                        }

                        $.extend(this.currentEffect, readyEffect);

                    }
                };

            return effectsObject;
        })(),

        easingEffect = (function () {
            var easingName = options.easing,
                onOpen,
                onClose;

            if (typeof easingName === 'string') {
                onOpen = onClose = easingName;

            } else if (typeof easingName === 'object') {
                if ('open' in easingName) {
                    onOpen = easingName.open;
                }

                if ('close' in easingName) {
                    onClose = easingName.close;
                }
            }

            return {
                onOpen: onOpen,
                onClose: onClose
            }
        })();

        addElementsToDom = function (){
            self.list.append(self.listScreen);
            self.listContainer.append(self.list);
            self.container.append(self.listContainer, self.selectBox, self.underOverlayLayer, self.selectBoxOverlay);

            element.hide().after(self.container);
        },

        addCssClasses = function (){
            self.container.addClass(skin.cssClass)
                .addClass(expansion.cssClass)
                .addClass(theme.cssClass)
                .addClass(options.additionalClass);
        },

        pushImages = function (){
            var selectedId = '';

            element.children().each(function (k){
                var img = $('<img>');

                img.attr({
                    'src': $(this).data('image'),
                    'id': 'sh-img-dropdown-image-' + k,
                    'alt': ''
                });

                self.list.append(img);

                $(this).addClass(img.attr('id'));

                if($(this).is(':selected')) {
                    selectedId = img.attr('id');
                }
            });

            return selectedId;
        };

        (function (){
            var selectedId;

            addElementsToDom();
            addCssClasses();
            selectedId = pushImages();

            effects.pushEffect(expansion.effect);
            effects.pushEffect(options.dropdownEffect);

            self.list.imagesLoaded(function (images){
                var listWrapperSize = 0,
                    listScreenSize = 0,
                    extraWidth;

                images.each(function (k){
                    var imgWrapper = $('<div></div>').addClass('sh-img-dropdown-image-wrapper'),
                        textBlock = $('<div></div>').addClass('sh-img-dropdown-textblock');

                    textBlock.text(element.children('.' + $(this).attr('id')).text());

                    imgWrapper.append($(this), textBlock);

                    if (options.imageLimit === 0 || options.imageLimit > k) {
                        imgWrapper.appendTo(self.listScreen);
                        listScreenSize += imgWrapper[expansion.expandSize]();

                    } else {
                        imgWrapper.appendTo(self.list);
                    }

                    listWrapperSize += imgWrapper[expansion.expandSize]();
                });

                self.list.css(expansion.expandSize, listWrapperSize);
                self.listScreen.css(expansion.expandSize, listScreenSize);
                self.listContainer.css(expansion.expandSize, listScreenSize);

                if ($.objectSize(expansion.containerOffset)) {
                    $.each(expansion.containerOffset, function (event, property){
                        var size,
                            propName,
                            newProperty = {};

                        for(propName in property) {
                            switch (propName) {
                                case 'margin-right':
                                case 'margin-left':
                                    size = 'width';
                                    break;

                                case 'margin-top':
                                case 'margin-bottom':
                                    size = 'height';
                                    break;
                            }
                        }

                        newProperty[propName] = $.getPercentagePart(self.listContainer[size](), property[propName]);

                        $.addToObject(effects.currentEffect[event], newProperty);
                    });
                }

                $.shHelper.callCallback(scrollbar, self.listContainer, {
                    skin: skin.scrollbarSkin,
                    contentElement: '.sh-img-dropdown-list',
                    axis: expansion.scrollbarAxis
                });

                if(expansion.extraWidth) {
                    extraWidth = self.listContainer.data('sh-scrollbar').wrapper.width();
                    self.listContainer.css('width', '+=' + extraWidth);
                }

                self.listContainer.hide();

                setSelectedImage(images.filter('[id="' + selectedId + '"]'));

                if ('ontouchstart' in document.documentElement) {
                    images.bind('touchstart', eventHandlers.touchImageSelect)
                        .bind('touchmove', eventHandlers.touchDragging);

                    self.selectBoxOverlay.bind('touchstart', eventHandlers.toggleDropDownVisibility);

                } else {
                    images.bind('click', eventHandlers.mouseImageSelect);

                    images.parent().bind('mouseover', eventHandlers.showImageText)
                        .bind('mouseout', eventHandlers.hideImageText);

                    self.selectBoxOverlay.bind('click', eventHandlers.toggleDropDownVisibility);
                }

                $.each(theme.events, function (eventName, eventProps){
                    eventProps.element.bind(eventName, eventProps.handler);
                });
            });
        }());
    };
})(jQuery);

/*! jQuery SH Image Select v1.0, Copyright 2012 Alexy Vauch! */
(function($) {
    /**
     * Creates a list of images for all matched elements.
     *
     * @example $("#select").shImageSelect();
     * @input "multiple" attribute requred. e.g.: <select id="select" multiple>
     * "data-image" attribute with image link value required. e.g.: <option data-image="image.jpg">image</option>
     *
     * @method shImageSelect
     * @return $
     * @param o {Object} A set of configuration properties (key/value pairs).
     */
    $.fn.shImageSelect = function(o){
        var defaults = {
                mode: 'checkbox', // Selection mode. Allowed values: 'checkbox', 'radio'.
                maxSelected: 0, // Limits the maximum number of images that can be selected. "0" - Unlim.
                axis: 'y', // Vertical/horizontal scroller. Allowed values: "x", "y".
                imageLimit: {
                    x: 3, // Limits the maximum number of visible images on the x axis. "0" - Unlim.
                    y: 3 // Limits the maximum number of visible images on the y axis. "0" - Unlim.
                },
                showText: true, // Show select option text over image? // Allowed values: true, false.
                additionalClass: '', // Name of additional plugin html container css class.
                theme: 'box', // Theme name.
                skin: 'light', // Skin name. Allowed values: "light", "dark", "naked"
                callbacks: { // Callback functions
                    onSelect: '',
                    onUnselect: '',
                    onSelectedLimit: ''
                }
            },
            options;

        options = $.extend(true, defaults, o);

        return this.each(function (){
            if(!$(this).attr('multiple')) {
                alert('You need to add "multiple" attribute to element');
                return true;
            }

            $(this).data('sh-image-select', new shImageSelect($(this), options, function (scrollbarOptions){
                $(this).shScrollbar(scrollbarOptions);
            }));
        });
    };

    /**
     * @constructor
     * @class shImageSelect
     * @param element {HTMLElement} The element to create the image list for.
     * @param options {Object} A set of configuration properties (key/value pairs).
     * @param scrollbar function within shScrollbar plugin initialization.
     */
    var shImageSelect = function (element, options, scrollbar){
        var self = this;

        this.wrapper = $('<div></div>').addClass('sh-img-select-wrapper');
        this.container = $('<div></div>').addClass('sh-img-select-container');
        this.screenContainer = $('<div></div>').addClass('sh-img-select-screen-container');

        /**
         * Selects one image from images list.
         *
         * @method select
         * @return undefined
         */
        this.select = function (image){
            if(selectedCounter.increment()) {
                element.children('[class="' + image.attr('id') + '"]').attr('selected', 'selected')
                    .end()
                    .triggerHandler('change');

                toggleSelectedLayer(image, 'select', options.callbacks.onSelect);
            }
        };


        /**
         * Unselects one image from images list.
         *
         * @method unselect
         * @return undefined
         */
        this.unselect = function (image){
            selectedCounter.decrement();

            element.children('[class="' + image.attr('id') + '"]').removeAttr('selected')
                .end()
                .triggerHandler('change');

            toggleSelectedLayer(image, 'unselect', options.callbacks.onUnselect);
        };

        var eventHandlers = {
            dragged: false,

            showImageText: function (){
                $(this).children('img').stop().fadeTo(300, 0.6);

                if(options.showText) {
                    $(this).children('.sh-img-select-textblock').stop().animate({
                        bottom: '5px'
                    }, 'fast');
                }
            },

            hideImageText: function (){
                $(this).children('img').stop().fadeTo(300, 1);

                if(options.showText) {
                    $(this).children('.sh-img-select-textblock').stop().animate({
                        bottom: '-100%'
                    }, 'fast');
                }
            },

            mouseImageSelect: function (e){
                var image = $(this).children('img');

                toggleSelect(image, $(this));

                e.preventDefault();
            },

            touchImageSelect: function (e){
                var imageContainer = $(this),
                    image = imageContainer.children('img');

                eventHandlers.dragged = false;

                setTimeout(function (){
                    if (eventHandlers.dragged) {
                        return;
                    }

                    toggleSelect(image, imageContainer);
                }, 300);

                e.preventDefault();
            },

            touchDragging: function (){
                eventHandlers.dragged = true;
            }
        },

        toggleSelect = function (image, imageContainer){
            if (options.mode === 'radio') {
                var imageId = image.attr('id'),
                    alreadySelected = false;

                element.children('[selected]').each(function (){
                    var image = self.screenContainer.find('[id="' + $(this).attr('class') + '"]');

                    if (imageId != $(this).attr('class')) {
                        self.unselect(image);

                    } else {
                        alreadySelected = true;
                        return true;
                    }
                });

                if (!alreadySelected) {
                    self.select(image);
                }

            } else {
                if(isSelected(imageContainer)) {
                    self.unselect(image);

                } else {
                    self.select(image);
                }
            }
        },

        toggleSelectedLayer = function (image, action, callback){
            var selectedLayer = image.parent().children('.sh-img-select-selected-layer');

            if(action == 'select') {
                selectedLayer.fadeTo('fast', theme.selectedLayerOpacity);

            } else {
                selectedLayer.fadeOut('fast');
            }

            if(callback) {
                $.shHelper.callCallback(callback, self.container);
            }
        },

        isSelected = function (imageWrapper){
            return imageWrapper.children('.sh-img-select-selected-layer').is(':visible');
        },

        selectedCounter = {
            count: 0,
            increment: function (){
                if(this.isLimit()) {
                    $.shHelper.callCallback(options.callbacks.onSelectedLimit, self.container);
                    return false;
                }

                this.count++;
                return true;
            },

            decrement: function (){
                this.count--;
            },

            isLimit: function (){
                if(options.maxSelected !== 0 && this.count >= options.maxSelected) {
                    return true;
                }

                return false;
            }
        },

        theme = (function (){
            var themeName = options.theme,
                cssClass = 'sh-img-select-theme-',
                selectedLayerOpacity = 0.6;

            switch (themeName) {
                case 'box':
                default:
                    cssClass += themeName;
                    break;

                case 'minimal':
                    selectedLayerOpacity = 1;
                    cssClass += themeName;
                    break;
            }

            return {
                cssClass: cssClass,
                selectedLayerOpacity: selectedLayerOpacity
            };
        })(),

        skin = (function (){
            var skinName = options.skin,
                cssClass = 'sh-img-select-',
                scrollbarSkin = 'light';

            switch (skinName) {
                case 'dark':
                    cssClass += skinName;
                    scrollbarSkin = skinName;
                    break;

                case 'light':
                default:
                    cssClass += skinName;
                    scrollbarSkin = skinName;
                    break;
            }

            return {
                cssClass: cssClass,
                scrollbarSkin: scrollbarSkin
            };

        })();

        (function (){
            var selectedImages = [];

            self.container.append(self.screenContainer);
            self.wrapper.append(self.container);
            element.hide().after(self.wrapper);

            self.wrapper.addClass(theme.cssClass)
                .addClass(skin.cssClass)
                .addClass(options.additionalClass);

            element.children().each(function (k){
                var img = $('<img>'),
                    identification = 'sh-img-select-image-' + k;

                self.container.append(img);

                img.attr({
                    'src': $(this).data('image'),
                    'id': identification,
                    'alt': ''
                });

                $(this).addClass(identification);

                if($(this).is(':selected')) {
                    selectedCounter.increment();
                    selectedImages.push(img);
                }
            });

            self.container.imagesLoaded(function (images){
                var imagesAxisX = 0,
                    screen = $('<div></div>').addClass('sh-img-select-screen'),
                    firstScreen = screen,
                    currentScreen,
                    screenId = 0,
                    screenLimit = options.imageLimit.x * options.imageLimit.y,
                    imageParents;

                images.each(function (){
                    var imgWrapper = $('<div></div>').addClass('sh-img-select-image-wrapper'),
                        textBlock = $('<div></div>').addClass('sh-img-select-textblock'),
                        selectedLayer = $('<div></div>').addClass('sh-img-select-selected-layer');

                    if(imagesAxisX == options.imageLimit.x) {
                        imgWrapper.css('clear', 'left');
                        imagesAxisX = 0;
                    }

                    if(!currentScreen || currentScreen.children().length == screenLimit) {
                        currentScreen = screen.clone().appendTo(self.screenContainer);
                        screenId += 1;
                    }

                    textBlock.text(element.children('.' + $(this).attr('id')).text());

                    imgWrapper.append($(this), textBlock, selectedLayer).appendTo(currentScreen);

                    if(screenId == 1) {
                        firstScreen = currentScreen;
                    }

                    imagesAxisX += 1;

                });

                imageParents = images.parent();

                $.each(selectedImages, function (k, image){
                    toggleSelectedLayer(image, 'select');
                });

                if(options.axis == 'y') {
                    self.screenContainer.children().css('clear', 'both');

                    self.container.css({
                        'min-width': firstScreen.width(),
                        'height': firstScreen.height()
                    });

                } else {
                    var newWidth = 0;

                    self.container.css({
                        'width': firstScreen.width(),
                        'min-height': firstScreen.height()
                    });

                    self.screenContainer.children().each(function (){
                        newWidth += $(this).width();
                    });

                    self.screenContainer.css('width', newWidth);
                }

                if ('ontouchstart' in document.documentElement) {
                    imageParents.bind('touchstart', eventHandlers.touchImageSelect)
                        .bind('touchmove', eventHandlers.touchDragging);

                } else {
                    imageParents.bind('click', eventHandlers.mouseImageSelect)
                        .bind('mouseover', eventHandlers.showImageText)
                        .bind('mouseout', eventHandlers.hideImageText);
                }

                $.shHelper.callCallback(scrollbar, self.container, {
                    axis: options.axis,
                    skin: skin.scrollbarSkin,
                    contentElement: '.sh-img-select-screen-container'
                });
            });
        }())
    };
})(jQuery);

/*! jQuery SH Scrollbar v1.0, Copyright 2012 Alexy Vauch! */
(function($) {
    /**
     * Adds customised scrollbar. Mobile devices friendly.
     *
     * @example $("#container").shScrollbar({contentElement: '#content_block'});
     *
     * @method shScrollbar
     * @return $
     * @param o {Object} A set of configuration properties (key/value pairs).
     */
    $.fn.shScrollbar = function (o){
        var defaults = {
                axis: 'y', // Vertical/horizontal scroller. Allowed values: "x", "y"
                contentElement: '', // The element to create the scrollbar for.
                skin: 'light', // Allowed values: "light", "dark"
                scrollLength: 30 // How many pixels must the mouse wheel scrolls at a time.
            },
            options;

        options = $.extend(true, defaults, o);

        return this.each(function (){
            var contentBlock = $(this).find(options.contentElement);

            if(!contentBlock.length) {
                alert('Could\'nt find content block.');

                return true;
            }

            $(this).data('sh-scrollbar', new shScrollbar($(this), contentBlock, options))
        });
    };

    /**
     * @constructor
     * @class shScrollbar
     * @param container {HTMLElement} The container element for scrollbar and content block.
     * @param contentBlock {HTMLElement} The element to create the scrollbar for.
     * @param options {Object} A set of configuration properties (key/value pairs).
     */
    var shScrollbar = function (container, contentBlock, options){
        this.wrapper = $('<div></div>').addClass('sh-scrollbar-wrapper');
        this.track = $('<div></div>').addClass('sh-scrollbar-track');
        this.slider = $('<div></div>').addClass('sh-scrollbar-slider');

        var self = this,
            trackStart = 0,
            trackFinish,
            oldPos = 0,
            savedPos = 0,
            clickDot = {
                x: 0,
                y: 0
            },
            sizeVector,
            offsetFrom,
            selectEvent,
            activeTouchDragging = false;

            var makeTouchDraggable = function (e){
                clickDot['y'] = e.originalEvent.touches[0].pageY;
                clickDot['x'] = e.originalEvent.touches[0].pageX;

                activeTouchDragging = true;
                e.preventDefault();
            },

            touchDragging = function (e){
                var currentFingerPos = {
                    'x': e.originalEvent.touches[0].pageX,
                    'y': e.originalEvent.touches[0].pageY
                };

                if (!activeTouchDragging) {
                    return;
                }

                self.slider.addClass('sh-scrollbar-draggable');

                setNewPosition( - (currentFingerPos[options.axis] - clickDot[options.axis] + savedPos));
            },

            stopTouchDragging = function (){
                savedPos = (oldPos === 0) ? oldPos : - oldPos;

                self.slider.removeClass('sh-scrollbar-draggable');

                activeTouchDragging = false;
            },

            makeMouseDraggable = function (e){
                clickDot['y'] = e.pageY;
                clickDot['x'] = e.pageX;

                $(this).addClass('sh-scrollbar-draggable');

                $(document).bind('mousemove', mouseDragging)
                    .bind('mouseup', stopMouseDragging)
                    .bind(selectEvent + '.disableSelection', function (e){
                        e.preventDefault();
                    })
            },

            mouseDragging = function(e){
                var currentMousePos = {
                    'x': e.pageX,
                    'y': e.pageY
                };

                setNewPosition(currentMousePos[options.axis] - clickDot[options.axis] + savedPos);
            },

            stopMouseDragging = function (){
                savedPos = oldPos;

                $(document).unbind('mousemove', mouseDragging)
                    .unbind('mouseup', stopMouseDragging)
                    .unbind(selectEvent + '.disableSelection');

                self.slider.removeClass('sh-scrollbar-draggable');
            },

            mouseWheellScrolling = function(event, delta) {
                setNewPosition(savedPos - delta * options.scrollLength);

                savedPos = oldPos;
                event.preventDefault();
            },

            setNewPosition = function (newPos){
                var contentOffset;

                if(newPos < trackStart) {
                    newPos = trackStart;

                } else if(newPos  > trackFinish) {
                    newPos = trackFinish;
                }

                if(newPos != oldPos) {
                    contentOffset = - (contentBlock[sizeVector]() - container[sizeVector]()) * ((newPos - trackStart) / (trackFinish));
                    contentBlock.css(offsetFrom, contentOffset);
                    self.slider.css(offsetFrom, newPos);
                    oldPos = newPos;
                }
            },

            skinClass = (function (){
                var skinClass;

                switch (options.skin) {
                    case 'light':
                    default:
                        skinClass = 'sh-scrollbar-light';
                        break;

                    case 'dark':
                        skinClass = 'sh-scrollbar-dark';
                        break;
                }

                return skinClass;
            })();

            (function (){
                var axisClass;

                selectEvent = $.support.selectstart ? 'selectstart' : 'mousedown';

                contentBlock.css('position', 'relative');

                self.track.append(self.slider).appendTo(self.wrapper);
                self.wrapper.appendTo(container);

                if(options.axis === 'y') {
                    axisClass = 'sh-scrollbar-track-y';
                    sizeVector = 'height';
                    offsetFrom = 'top';

                } else {
                    axisClass = 'sh-scrollbar-track-x';
                    sizeVector = 'width';
                    offsetFrom = 'left';
                }

                self.wrapper.addClass(skinClass)
                    .addClass(axisClass);

                if(contentBlock[sizeVector]() <= container[sizeVector]()) {
                    self.wrapper.remove();
                    return;
                }

                trackFinish = self.track[sizeVector]() - self.slider[sizeVector]();

                if ('ontouchstart' in document.documentElement) {
                    contentBlock.bind('touchstart', makeTouchDraggable)
                        .bind('touchmove', touchDragging)
                        .bind('touchend', stopTouchDragging);

                } else {
                    contentBlock.mousewheel(mouseWheellScrolling);
                    self.slider.bind('mousedown', makeMouseDraggable);
                }
            }());
    };
})(jQuery);

/*! SH helper functions */
(function($) {
    $.extend({
        shHelper: {
            callCallback: function (callback, newThis, args){
                if(typeof callback === 'function') {
                    callback.call(newThis, args);
                }
            }
        },

        addToObject: function (target, object){
            $.each(object, function (k, v){
                if (false === k in target) {
                    target[k] = v;
                }
            });

            return target;
        },

        objectSize: function(obj) {
            var size = 0,
                key;

            for (var key in obj) {
                if (obj.hasOwnProperty(key)) {
                    size++;
                }
            }

            return size;
        },

        getPercentagePart: function (number, percentString) {
            var percent = parseInt(percentString.replace('%', ''));

            return number / 100 * percent;
        }
    });
})(jQuery);

/**
 * "jQuery Mouse Wheel" - specifies the use of the mouse wheel..
 * @see https://github.com/brandonaaron/jquery-mousewheel for more info.
 */
(function(d){function e(a){var b=a||window.event,c=[].slice.call(arguments,1),f=0,e=0,g=0;a=d.event.fix(b);a.type="mousewheel";b.wheelDelta&&(f=b.wheelDelta/120);b.detail&&(f=-b.detail/3);g=f;void 0!==b.axis&&b.axis===b.HORIZONTAL_AXIS&&(g=0,e=-1*f);void 0!==b.wheelDeltaY&&(g=b.wheelDeltaY/120);void 0!==b.wheelDeltaX&&(e=-1*b.wheelDeltaX/120);c.unshift(a,f,e,g);return(d.event.dispatch||d.event.handle).apply(this,c)}var c=["DOMMouseScroll","mousewheel"];if(d.event.fixHooks)for(var h=c.length;h;)d.event.fixHooks[c[--h]]=
    d.event.mouseHooks;d.event.special.mousewheel={setup:function(){if(this.addEventListener)for(var a=c.length;a;)this.addEventListener(c[--a],e,!1);else this.onmousewheel=e},teardown:function(){if(this.removeEventListener)for(var a=c.length;a;)this.removeEventListener(c[--a],e,!1);else this.onmousewheel=null}};d.fn.extend({mousewheel:function(a){return a?this.bind("mousewheel",a):this.trigger("mousewheel")},unmousewheel:function(a){return this.unbind("mousewheel",a)}})})(jQuery);

/**
 * "imagesLoaded" - cached images loader.
 * @see http://desandro.github.com/imagesloaded/ for more info.
 */
(function(c,n){var l="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==";c.fn.imagesLoaded=function(f){function m(){var b=c(i),a=c(h);d&&(h.length?d.reject(e,b,a):d.resolve(e));c.isFunction(f)&&f.call(g,e,b,a)}function j(b,a){b.src===l||-1!==c.inArray(b,k)||(k.push(b),a?h.push(b):i.push(b),c.data(b,"imagesLoaded",{isBroken:a,src:b.src}),o&&d.notifyWith(c(b),[a,e,c(i),c(h)]),e.length===k.length&&(setTimeout(m),e.unbind(".imagesLoaded")))}var g=this,d=c.isFunction(c.Deferred)?c.Deferred():
    0,o=c.isFunction(d.notify),e=g.find("img").add(g.filter("img")),k=[],i=[],h=[];c.isPlainObject(f)&&c.each(f,function(b,a){if("callback"===b)f=a;else if(d)d[b](a)});e.length?e.bind("load.imagesLoaded error.imagesLoaded",function(b){j(b.target,"error"===b.type)}).each(function(b,a){var d=a.src,e=c.data(a,"imagesLoaded");if(e&&e.src===d)j(a,e.isBroken);else if(a.complete&&a.naturalWidth!==n)j(a,0===a.naturalWidth||0===a.naturalHeight);else if(a.readyState||a.complete)a.src=l,a.src=d}):m();return d?d.promise(g):
    g}})(jQuery);