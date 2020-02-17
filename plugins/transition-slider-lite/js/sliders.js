"use strict";
(function($) {
    $(document).ready(function() {
        var $loader = $(".STX-loader-container").hide();
        $(".wrap").show();

        var self = this;

        this.sliders = $.parseJSON(sliders);
        var arr = [];

        for (var key in this.sliders) {
            arr.push(this.sliders[key]);
        }
        this.sliders = arr;

        var modal = $(".STX-modal-window");
        var modalTitle = $(".STX-modal-window-title");
        var importInput = $(".STX-modal-window-import-text");
        var importText = $(".STX-editing-slide-title");
        var slider;
        var _s;

        var $templatesModal = $("#templates-modal");
        var $modalBackdrop = $(".media-modal-backdrop");
        var $body = $("body");
        var _pro = false

        $(".STX-designs").click(function() {
            $templatesModal.show();
            $modalBackdrop.show();
            $body.css("overflow", "hidden");
        });

        $(".media-modal-close").click(function(e) {
            $modalBackdrop.hide();
            $templatesModal.hide();
            $(".media-modal").hide();
            $body.css("overflow", "auto");
        });

        function getSelectedSliders() {
            var arr = [];
            $(".STX-edit-slider-box input:checked").each(function(index) {
                arr.push(this.name);
            });
            return arr;
        }

        function showLoader() {
            $loader.show();
        }

        function hideLoader() {
            $loader.hide();
        }

        function downloadObjectAsJson(exportObj, exportName) {
            var dataStr = "data:text/json;charset=utf-8," + encodeURIComponent(exportObj);
            var downloadAnchorNode = document.createElement("a");
            downloadAnchorNode.setAttribute("href", dataStr);
            downloadAnchorNode.setAttribute("download", exportName + ".txt");
            document.body.appendChild(downloadAnchorNode); // required for firefox
            downloadAnchorNode.click();
            downloadAnchorNode.remove();
        }

        function addSlider(slider) {
            var slider_display_name;
            var url = "";
            var type;

            slider.instanceName != "" ? (slider_display_name = slider.instanceName) : (slider_display_name = slider.name);

            if (!jQuery.isEmptyObject(slider.slides)) {
                url = slider.slides.length > 0 ? slider.slides[0].src : "";
            }

            if (/\.(jpg|jpeg|gif|png)$/i.test(url)) {
                type = '<img title="Sort"  class="STX-image-preview" src="' + url + '">';
            } else if (/\.(mp4|ogg|ogv|webm)$/i.test(url)) {
                type = '<video title="Sort"  class="STX-video-preview" src="' + url + '"></video>';
            } else {
                type = '<div title="Sort"  class="STX-noslides"><p>No slides added</p></div>';
            }

            var markup = $(
                '<div class="STX-rect STX-isAdded STX-edit-slider-box" data-title="' +
                    slider_display_name +
                    '" data-sliderid="' +
                    slider.id +
                    '">' +
                    type +
                    '<div class="STX-box-overlay STX-box-on-hover">' +
                    '<a name="' +
                    slider.id +
                    '" class="STX-edit-link STX-btn STX-button-green STX-radius-global STX-uc STX-h5 edit" title="Edit ' +
                    slider_display_name +
                    '">Edit</a>' +
                    '<label class="STX-checkbox-container">' +
                    '<input type="checkbox" name="' +
                    slider.id +
                    '">' +
                    '<span class="STX-checkbox-checkmark"></span>' +
                    "</label>" +
                    '<div class="STX-slider-settings-btn-small btn-sm settings" name="' +
                    slider.id +
                    '" title="Settings">' +
                    '<div class="STX-slider-small-settings-wrapper">' +
                    '<div class="STX-slider-view-btn-small view btn-sm" title="View"></div>' +
                    '<div class="STX-slider-copy-btn-small btn-sm duplicate" name="' +
                    slider.id +
                    '" title="Duplicate"></div>' +
                    "</div>" +
                    "</div>" +
                    '<div class="STX-slider-trash-btn-small trash" name="' +
                    slider.id +
                    '" title="Delete"></div>' +
                    "</div>" +
                    '<div class="STX-box-placeholder" data-align="">' +
                    '<div class="STX-box-placeholder-title">' +
                    '<a class="STX-h4">' +
                    slider_display_name +
                    "</a>" +
                    "</div>" +
                    '<div class="STX-box-placeholder-buttons">' +
                    "</div>" +
                    "</div>" +
                    "</div>"
            ).appendTo($(".STX-container"));
        }

        var keys = [];
        for (var key in this.sliders) {
            keys.push(key);
            if (typeof this.sliders[key].date == "undefined") this.sliders[key].date = "";
        }

        $("#sliders-table").empty();
        $(".STX-isAdded").remove();
        for (var i = 0; i < arr.length; i++) {
            var slider = arr[i];
            if (slider) addSlider(slider);
        }

        sortByDate(true);

        $(".edit").click(function(e) {
            e.preventDefault();
            var id = this.getAttribute("name");
            window.location = window.location.origin + window.location.pathname + "?page=transition_slider_admin&action=edit&id=" + id;
        });
        $(".duplicate").click(function(e) {
            e.preventDefault();
            var id = this.getAttribute("name");
            duplicateSlider(id);
        });
        $(".trash").click(function(e) {
            e.preventDefault();
            var id = this.getAttribute("name");
            deleteSliders([id]);
        });
        $(".undo").click(function(e) {
            e.preventDefault();
            window.location = window.location.origin + window.location.pathname + "?page=transition_slider_admin&action=undo";
        });

        $('.STX-edit-slider-box input[type="checkbox"]').change(function() {
            $('.STX-edit-slider-box[data-sliderid="' + this.name + '"]').toggleClass("selected", this.checked);
            updateHeader();
        });

        function updateHeader() {
            var selected = getSelectedSliders();

            $(".delete_all_sliders").toggle(selected.length > 0);
            $(".STX-slider-export-btn").toggle(selected.length > 0);
        }

        updateHeader();

        function addTemplateSliders(arr) {
            var $templates = $(".STX-templates");

            arr.forEach(function(template) {
                var bgUrl = window.stx_plugin_url + "assets/templates/" + template.name + ".jpg";

                var btnText = template.free || _pro ? "Import" : "Buy Pro"
                var btnClass = template.free || _pro ? "template-import-btn" : "template-buy-pro"

                var $template = jQuery('<div class="template">' + '<div class="template-content">' + '<h2 class="template-title">' + template.title + "</h2>" + '<div id="' + template.name + '" class="'+btnClass+'">'+btnText+'</div>' + "</div>" + "</div>")
                    .appendTo($templates)
                    .css("background", "url(" + bgUrl + ")");
            });
        }

        var templateSliders = [
            {
                name: "business",
                title: "Business Slider",
                free: true
            },
            {
                name: "products",
                title: "Products Sales Slider"
            },
            {
                name: "travel",
                title: "Travel Slider"
            },
            {
                name: "car",
                title: "Car Sales Slider"
            },
            {
                name: "marketing",
                title: "Marketing Slider"
            },
            {
                name: "video_block",
                title: "Video Block Slider"
            },
            {
                name: "video_hero",
                title: "Hero Video Slider"
            },
            {
                name: "furniture_stores",
                title: "Furniture Stores Slider"
            },
            {
                name: "clothing_collection",
                title: "Clothing Collection Slider"
            }, 
            {
                name: "agency",
                title: "Agency Slider"
            },
            {
                name: "christmas",
                title: "Christmas Slider"
            },
            {
                name: "static",
                title: "Static Slider"
            },
            {
                name: "hotel_and_booking",
                title: "Hotel And Booking Slider"
            },
            {
                name: "seo_and_digital_marketing",
                title: "SEO & Digital Marketing"
            },
            {
                name: "restaurant",
                title: "Restaurant"
            },
            {
                name: "tasty_food",
                title: "Tasty Food"
            }
        ];

        addTemplateSliders(templateSliders);

        function duplicateSlider(id) {
            var data = "action=transitionslider_duplicate&security=" + window.stx_nonce + "&currentId=" + id;

            $.ajax({
                type: "POST",
                url: "admin-ajax.php?page=transition_slider_admin",
                data: data,

                success: function(data, textStatus, jqXHR) {
                    location.reload();
                },

                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert("Status: " + textStatus);
                    alert("Error: " + errorThrown);
                }
            });
        }

        function deleteSliders(arr) {
            var msg = "";
            var data = "action=transitionslider_delete&security=" + window.stx_nonce;

            if (arr) {
                if (arr.length == 1) msg = "Delete slider";
                else msg = "Delete sliders";
                data += "&currentId=" + arr;
            } else {
                msg = "Delete sliders";
            }

            if (confirm(msg + ". Are you sure?")) {
                $.ajax({
                    type: "POST",
                    url: "admin-ajax.php?page=transition_slider_admin",
                    data: data,

                    success: function(data, textStatus, jqXHR) {
                        location.reload();
                    },

                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        alert("Status: " + textStatus);
                        alert("Error: " + errorThrown);
                    }
                });
            }
        }

        function exportSliders(arr) {
            var data = "action=transitionslider_export&security=" + window.stx_nonce + "&currentId=" + arr.join(",");
            var name = arr.length === 1 ? "transition-slider" : "transition-sliders";

            $.ajax({
                type: "POST",
                url: "admin-ajax.php?page=transition_slider_admin",
                data: data,

                success: function(data, textStatus, jqXHR) {
                    downloadObjectAsJson(data, name);
                },

                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert("Status: " + textStatus);
                    alert("Error: " + errorThrown);
                }
            });
        }

        function getSliderOptions(id, onCompete) {
            var data = "action=transitionslider_get_slider&security=" + window.stx_nonce + "&currentId=" + id;

            $.ajax({
                type: "POST",
                url: "admin-ajax.php?page=transition_slider_admin",
                data: data,

                success: function(data, textStatus, jqXHR) {
                    onCompete.call(this, JSON.parse(data))
                },

                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    // alert("Status: " + textStatus);
                    // alert("Error: " + errorThrown);
                }
            });
        }

        $(".delete_all_sliders").click(function(e) {
            e.preventDefault();
            var selected = getSelectedSliders();
            deleteSliders(selected);
        });

        $(".STX-slider-export-btn").click(function(e) {
            e.preventDefault();
            var selected = getSelectedSliders();
            exportSliders(selected);
        });

        $(".bulkactions-apply").click(function() {
            var action = $(this)
                .parent()
                .find("select")
                .val();
            if (action != "-1") {
                var list = [];
                $(".row-checkbox").each(function() {
                    if ($(this).is(":checked")) list.push($(this).attr("name"));
                });
                if (list.length > 0) {
                    window.location = window.location.origin + window.location.pathname + "?page=transition_slider_admin&action=delete&id=" + list.join(",");
                }
            }
        });

        $(".STX-dashboard-wrapp").show();

        $(".STX-btn-menu").click(function(e) {
            $(".STX-btn-menu")
                .parent()
                .removeClass("STX-nav-active");
            $(this)
                .parent()
                .addClass("STX-nav-active");

            $(".STX-form-tab").hide();
            $(".options_" + $(this).attr("data-form-name")).fadeIn("fast", function() {});
        });

        $(".STX-form-tab").hide();
        $('.STX-btn-menu[data-form-name="general"]')
            .parent()
            .addClass("STX-nav-active");

        $(".STX-btn-topbar").click(function(e) {
            $(".STX-form-tab").hide();
            $(".options_" + $(this).attr("data-form-name")).fadeIn("fast", function() {});
        });

        $(".copy-shortcode").click(function() {
            var id = $(this).attr("id");
            var copied = "[transitionslider id='" + id + "']";
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val(copied).select();
            document.execCommand("copy");
            $temp.remove();
            $(".copy-shortcode").text("Copy");
            $(this)
                .parent()
                .addClass("slider-highlightText");
            $(".copy-shortcode").removeClass("STX-copy-shortcode-highlight");
            $(this).addClass("STX-copy-shortcode-highlight");
            $(this).text("Copied!");
        });

        $(".dropdown").click(function() {
            $(this)
                .attr("tabindex", 1)
                .focus();
            $(this).toggleClass("active");
            $(this)
                .find(".dropdown-menu")
                .slideToggle(300);
        });
        $(".dropdown").focusout(function() {
            $(this).removeClass("active");
            $(this)
                .find(".dropdown-menu")
                .slideUp(300);
        });
        $(".dropdown .dropdown-menu li").click(function() {
            $(this)
                .parents(".dropdown")
                .find("span")
                .text($(this).text());
            $(this)
                .parents(".dropdown")
                .find("input")
                .attr("value", $(this).attr("id"));
            $(this)
                .parents(".dropdown")
                .find("input")
                .attr("selected", "true");
        });

        $(".dropdown-menu li").click(function() {
            var getVal = $(this)
                .parents(".dropdown")
                .find("input")
                .val();
            switch (getVal) {
                case "newestFirst":
                    sortByDate(true);
                    break;
                case "oldestFirst":
                    sortByDate();
                    break;
                case "selectAll":
                    $(".STX-checkbox-container input")
                        .prop("checked", true)
                        .trigger("change");
                    // $(".STX-edit-slider-box").addClass('selected')
                    break;
                case "selectNone":
                    $(".STX-checkbox-container input")
                        .prop("checked", false)
                        .trigger("change");
                    // $(".STX-edit-slider-box").removeClass('selected')
                    break;
            }
        });

        addListeners();

        function sortByDate(asc) {
            self.sliders.sort(function(a, b) {
                a.date = a.date || "2000-01-01 00:00:00";
                b.date = b.date || "2000-01-01 00:00:00";
                return new Date(a.date) - new Date(b.date);
            });
            if (asc) self.sliders.reverse();
            self.sliders.forEach(function(slider) {
                $('.STX-edit-slider-box[data-sliderid="' + slider.id + '"]').appendTo($(".STX-container"));
            });
        }

        function convertStrings(obj) {
            $.each(obj, function(key, value) {
                if (typeof value == "object" || typeof value == "array") {
                    convertStrings(value);
                } else if (!isNaN(value)) {
                    if (obj[key] === "") delete obj[key];
                    else obj[key] = Number(value);
                } else if (value === "true") {
                    obj[key] = true;
                } else if (value === "false") {
                    obj[key] = false;
                }
            });
        }



        function addListeners() {
            $(".view").click(function(e) {
                e.preventDefault();

                $("#preview-slider-modal").show();

                $body.css("overflow", "hidden");

                var id = $(this).parent().parent().attr("name")

                getSliderOptions(id, function(_s){

                    for (var key in _s.slides) {
                        var slide = _s.slides[key];
                        if (slide.elements) {
                            for (var key2 in slide.elements) {
                                delete slide.elements[key2].node;
                            }
                        }
                    }

                    convertStrings(_s);

                    if ($.isEmptyObject($("#slider-preview").data())) $("#slider-preview").transitionSlider(_s);
                    else {
                        slider = $("#slider-preview").data("transitionSlider");
                        slider.reloadSlider(_s);
                    }

                })

            });

            $(".settings").each(function(i, item) {
                $(item).mouseover(function() {
                    $(this)
                        .parent()
                        .find(".STX-slider-small-settings-wrapper")
                        .stop()
                        .fadeIn("fast");
                });
                $(item).mouseout(function() {
                    $(this)
                        .parent()
                        .find(".STX-slider-small-settings-wrapper")
                        .stop()
                        .fadeOut("fast");
                });
            });
        }

        function openModal(type, title) {
            modal.fadeIn("fast", function() {});

            modalTitle.text(title);
            $(".slider_preview").hide();

            modal.removeClass("previewActive");
            modal.removeClass("importActive");

            switch (type) {
                case "import":
                    modal.addClass("importActive");
                    importInput.show();
                    importText.show();
                    break;
            }
        }
        function closeModal() {
            modal.fadeOut("fast", function() {});

            if (modal.hasClass("importActive")) {
                $("video").each(function() {
                    $(this)
                        .get(0)
                        .pause();
                });
            }
        }

        $(".STX-modal-close-btn, .STX-modal-window-overlay").click(function(e) {
            closeModal();
        });

        $("#import-sliders").click(function(e) {
            openModal("import", "Import Sliders");
        });

        function getSliderTitle(element) {
            return element
                .parent()
                .parent()
                .attr("data-title");
        }

        $(".template-buy-pro").click(function(e) {
            window.open("https://codecanyon.net/item/transition-slider-wordpress-plugin/23531533?ref=creativeinteractivemedia", "_blank")
        })

        $(".template-import-btn").click(function(e) {
            showLoader();

            $.ajax({
                dataType: "text",
                url: window.stx_plugin_url + "assets/templates/" + this.id + ".json",
                data: "",
                success: function(data) {
                    var ajaxUrl = "admin-ajax.php?page=transition_slider_admin";
                    var slider = data;

                    $.ajax({
                        type: "POST",

                        url: ajaxUrl,

                        data: {
                            slider: slider,
                            security: window.stx_nonce,
                            action: "transitionslider_import"
                        },

                        success: function(data, textStatus, jqXHR) {
                            location.reload();
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            alert(errorThrown);
                            hideLoader();
                        }
                    });
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert(errorThrown);
                    hideLoader();
                }
            });
        });
    });
})(jQuery);
