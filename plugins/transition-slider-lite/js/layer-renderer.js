"use strict";

var STX = STX || {};

STX.LayerRenderer = function(params) {
    var self = this;

    var id = 0;
    this.layerScale = 0;

    this.onLayerClick = params.onLayerClick;
    this.onLayerMove = params.onLayerMove;

    this.$layers = jQuery(".layer-container");

    this.$layers.bind("mousedown", function(e){
        self.dragging = true
        self.dragOriginX = e.clientX
        self.dragOriginY = e.clientY
    })

    this.$layers.bind("mousemove", function(e){
        if(self.dragging){
            self.dragChangeX = e.clientX - self.dragOriginX
            self.dragChangeY = e.clientY - self.dragOriginY
            self.dragOriginX = e.clientX
            self.dragOriginY = e.clientY
            self.onLayerMove({
                x: (self.dragChangeX) / self.layerScale, 
                y: (self.dragChangeY) / self.layerScale, 
            })
        }
        
    })

    window.addEventListener('mouseup', function(e) {
        self.dragging = false
    });

    this.render = function(elements) {
        this.elements = elements;

        self.clear();

        self.nodes = 0;

        if (elements) {
            addNodeElements(elements);
        }
    };

    this.resize = function(sw, sh, lw, lh) {
        if (sw && sh && lw && lh) updateLayerSizeForSlide(sw, sh, lw, lh);
    };

    this.renderAddedElement = function(elements) {
        this.elements = elements;
        addNodeElement(elements[elements.length - 1]);
        updateElementProperties(elements[elements.length - 1]);
    };

    this.updateElement = function(index, settingName) {
        updateElementProperties(this.elements[index], settingName);
    };

    this.focusElement = function(index) {
        if (this.elements && this.elements[index] && this.elements[index].node) {
            jQuery(this.elements[index].node).addClass("focused-element");
        }
    };

    this.unfocusElement = function() {
        jQuery(".focused-element").removeClass("focused-element");
    };

    this.clear = function() {
        this.$layers.empty();
    };

    this.removeElement = function(index) {
        if (this.elements && this.elements[index] && this.elements[index].node) {
            jQuery(this.elements[index].node).remove();
        }
    };

    function loadFont(element) {
        if (element.fontFamily) {
            WebFont.load({
                google: {
                    families: [element.fontFamily]
                },
                fontactive: function() {
                    updateElementPosition(element);
                },
                fontinactive: function() {
                    updateElementPosition(element);
                }
            });
        }
    }

    function updateElementProperties(element, settingName) {

        var node = element.node,
            $node = jQuery(node);

        // $node.resizable({
        //     //aspectRatio: true,
        //     handles: {
        //         'ne': '#negrip',
        //         'se': '#segrip',
        //         'sw': '#swgrip',
        //         'nw': '#nwgrip'
        //     }
        // });

        switch(settingName){
            case "src":
                if (element.src) node.src = element.src;
                break;
            case "content":
                if (typeof element.content == "string") node.innerHTML = element.content;
                break;

            case "fontFamily":
                if (element.fontFamily) node.style.fontFamily = element.fontFamily;
                break;

            case "textColor":
            case "backgroundColor":
            case "borderColor":
                if (element.textColor) node.style.color = element.textColor;
                if (element.backgroundColor) node.style.backgroundColor = element.backgroundColor;
                if (element.borderColor) node.style.borderColor = element.borderColor;

                if (element.hover) {
                    node.onmouseover = function() {
                        if (element.hover.backgroundColor) node.style.backgroundColor = element.hover.backgroundColor;
                        if (element.hover.textColor) node.style.color = element.hover.textColor;
                        if (element.hover.borderColor) node.style.borderColor = element.hover.borderColor;
                    };

                    node.onmouseout = function() {
                        if (element.backgroundColor) node.style.backgroundColor = element.backgroundColor;
                        if (element.textColor) node.style.color = element.textColor;
                        if (element.borderColor) node.style.borderColor = element.borderColor;
                    };
                }

                break;

            case "fontWeight":
                if (element.fontWeight) node.style.fontWeight = element.fontWeight;
                break;

            case "position":
            case "position.offsetX":
            case "position.offsetY":
            case "position.x":
            case "position.y":
                updateElementPosition(element);
                break;

            default:
                switch (element.type) {
                    case "text":
                        loadFont(element);
                        break;
                }

                if (element.content) node.innerHTML = element.content;
                if (element.fontFamily) node.style.fontFamily = element.fontFamily;
                if (element.fontSize) node.style.fontSize = String(element.fontSize).replace("px", "") + "px";
                if (element.backgroundColor) node.style.backgroundColor = element.backgroundColor;
                if (element.fontWeight) node.style.fontWeight = element.fontWeight;
                if (element.textColor) node.style.color = element.textColor;
                if (element.textAlign) node.style.textAlign = element.textAlign;
                if (element.lineHeight) node.style.lineHeight = element.lineHeight + "px";
                else node.style.lineHeight = "initial";

                if (element.padding) node.style.padding = element.padding;

                if (element.hasOwnProperty("paddingTop")) node.style.paddingTop = element.paddingTop + "px";
                if (element.hasOwnProperty("paddingRight")) node.style.paddingRight = element.paddingRight + "px";
                if (element.hasOwnProperty("paddingBottom")) node.style.paddingBottom = element.paddingBottom + "px";
                if (element.hasOwnProperty("paddingLeft")) node.style.paddingLeft = element.paddingLeft + "px";

                if (element.borderRadius) node.style.borderRadius = element.borderRadius + "px";
                if (element.size) {
                    node.style.setProperty("width", element.size + "px");
                    node.style.setProperty("height", "auto");
                }
                if (element.width) {
                    node.style.width = element.width + "px";
                    if (!element.height) node.style.height = "auto";
                }
                if (element.height) {
                    node.style.height = element.height + "px";
                    if (!element.width) node.style.width = "auto";
                }

                if (element.borderWidth) node.style.borderWidth = element.borderWidth + "px";
                if (element.borderColor) node.style.borderColor = element.borderColor;
                if (element.borderStyle) node.style.borderStyle = element.borderStyle;

                if (element.customCSS) $node.attr("style", $node.attr("style") + "; " + element.customCSS);

                updateElementPosition(element);

                node.style.transition = "color .3s, backgroundColor .3s";

                if (element.hover) {
                    node.onmouseover = function() {
                        if (element.hover.backgroundColor) node.style.backgroundColor = element.hover.backgroundColor;
                        if (element.hover.textColor) node.style.color = element.hover.textColor;
                        if (element.hover.borderColor) node.style.borderColor = element.hover.borderColor;
                    };

                    node.onmouseout = function() {
                        if (element.backgroundColor) node.style.backgroundColor = element.backgroundColor;
                        if (element.textColor) node.style.color = element.textColor;
                        if (element.borderColor) node.style.borderColor = element.borderColor;
                    };
                }

                break;


        }


    }

    function updateElementPosition(element) {

        var node = element.node,
            $node = jQuery(node);

        element.position.offsetX = element.position.offsetX || 0;
        element.position.offsetY = element.position.offsetY || 0;

        if (element.position.x === "center") $node.css({ left: "calc(50% - " + $node.outerWidth() / 2 + "px + " + element.position.offsetX + "px)" });
        else if (element.position.x === "left") $node.css({ left: element.position.offsetX + "px" });
        else if (element.position.x === "right") $node.css({ left: "calc(100% - " + $node.outerWidth() + "px - " + element.position.offsetX + "px)" });
        else node.style.setProperty("left", element.position.x.toString() + "%");

        if (element.position.y === "center") $node.css({ top: "calc(50% - " + $node.outerHeight() / 2 + "px - " + element.position.offsetY + "px)" });
        else if (element.position.y === "top") $node.css({ top: element.position.offsetY + "px" });
        else if (element.position.y === "bottom") $node.css({ top: "calc(100% - " + $node.outerHeight() + "px - " + element.position.offsetY + "px)" });
        else node.style.setProperty("top", element.position.y.toString() + "%");
    }

    function updateLayerSizeForSlide(sw, sh, lw, lh) {

        var layerWidth = lw;
        var layerHeight = lh;
        var slideWidth = sw;
        var slideHeight = sh;

        self.$layers.css({
            width: layerWidth - 8,
            height: layerHeight - 8
        });

        var scaleX = slideWidth / layerWidth;
        var scaleY = slideHeight / layerHeight;
        var baseScale = scaleX > scaleY ? scaleY : scaleX;
        self.layerScale = baseScale;

        self.$layers.css({
            "-webkit-transform": "scale(" + baseScale + ") translate(-" + layerWidth / 2 + "px, -" + layerHeight / 2 + "px)"
        });

        self.elements.forEach(function(element) {
            updateElementPosition(element);
        });
    }

    function addNodeElement(element) {

        switch (element.type) {
            case "text":
                element.node = document.createElement("div");
                break;
        }

        element.node.classList.add("element");
        self.$layers.append(jQuery(element.node));

        element.node.id = self.nodes;

        self.nodes++;

        element.node.onmousedown = function(e) {
            self.onLayerClick(Number(this.id), e.shiftKey);
        };

        // element.node.onclick = function(e) {
        //     self.onLayerClick(Number(this.id), e.shiftKey);
        // };

        updateElementProperties(element);
    }

    function addNodeElements(elements) {
        elements.forEach(function(element) {
            addNodeElement(element);
        });
    }

    function updateElements(elements) {
        elements.forEach(function(element) {
            updateElementPosition(element);
        });
    }

    function updateIndexes() {
        self.elements.forEach(function(element) {
            if (element.node) element.node.id = self.elements.indexOf(element);
        });
    }
};
