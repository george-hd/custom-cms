$(function(){

    $('.cms-language').mouseenter(function() {
        $('.langs').css({'display': 'block'});
    }).mouseleave(function() {
        $('.langs').css({'display': 'none'});
    });

    $('body').on('click', '.cms-language', function() {
        $.ajax({
            url: '/Cms/public/admin/site-options/languages',
            method: 'POST',
            data: {
                setLang: $(this).html(),
                action: 'change-site-lang'
            }
        }).done(function(msg) {
            location.reload();
        });
    });

    //*******SITE ADMINISTRATORS SET*******//

    if($('#add-admin').length > 0) {
        $('#add-admin').colorbox({
            href: '/Cms/public/admin/master-admin/create-admin',
            overlayClose: true,
            width: '30%',
            height: '60%',
            close: 'x',
            onComplete: function() {
                $('#create-admin-btn').on('click', function() {
                    $.ajax({
                        url: '/Cms/public/admin/master-admin/create-admin',
                        method: 'POST',
                        data: {
                            adminName: $('#admin-name').val(),
                            adminPass: $('#password').val(),
                            adminRole: $('#admin-role').val(),
                            action: 'create-admin'
                        }
                    }).done(function(msg) {
                        $('#cboxLoadedContent').append(msg);
                        setTimeout(function() {
                            location.reload();
                        },800);
                    });
                });
            }
        });
        if($('#admin-list').length > 0) {
            $('body').on('click', '.delete', function () {
                $.ajax({
                    url: '/Cms/public/admin/master-admin/delete-admin',
                    method: 'POST',
                    data: {
                        adminId: $(this).parent().find('.admin-id').html(),
                        action: 'delete-admin'
                    }
                }).done(function (msg) {
                    $('.options-container').append(msg);
                    setTimeout(function () {
                        location.reload();
                    }, 800);
                });
            });

            $('.edit').colorbox({
                href: '/Cms/public/admin/master-admin/edit-admin/',
                overlayClose: true,
                width: '30%',
                height: '60%',
                close: 'x',
                onComplete: function() {
                    $.ajax({
                        method: 'POST',
                        url: '/Cms/public/admin/master-admin/edit-admin',
                        data: {
                            adminId: $(this).parent().find('.admin-id').html(),
                            action: 'edit-admin'
                        }
                    }).done(function(msg) {
                        msg = JSON.parse(msg);
                        //console.log(msg);
                        $('#adm-id').val(msg.id);
                        $('#admin-name').val(msg.name);
                        $('#password').val(msg.password);
                        $('#admin-role option[value='+msg.role_id+']').attr('selected', 'selected');
                    });

                    $('#update-admin-btn').on('click', function() {
                        $.ajax({
                            url: '/Cms/public/admin/master-admin/edit-admin',
                            method: 'POST',
                            data: {
                                adminId: $('#adm-id').val(),
                                admin: $('#admin-name').val(),
                                adminPass: $('#password').val(),
                                adminRole: $('#admin-role').val(),
                                action: 'update-admin'
                            }
                        }).done(function(msg) {
                            $('#cboxLoadedContent').append(msg);
                            setTimeout(function() {
                                location.reload();
                            },800);
                        });
                    });
                }
            });
        }
    }

    //*******SITE LANGUAGES SET*******//

    if($('#add-lang').length > 0) {
        function initAddLangActions() {
            $('#add-lang').colorbox({
                href: '/Cms/public/admin/site-options/languages/create',
                overlayClose: true,
                width: '30%',
                height: '50%',
                close: 'x',
                onComplete: function () {
                    $('#create-lang-btn').on('click', function () {
                        $.ajax({
                            url: '/Cms/public/admin/site-options/languages',
                            method: 'POST',
                            data: {
                                langAbbreviation: $('#langAbbreviation').val(),
                                language: $('#langVal').val(),
                                action: 'create-language'
                            }
                        }).done(function (msg) {
                            $('#cboxLoadedContent').append(msg);
                            setTimeout(function () {
                                location.reload();
                            }, 800);
                        });
                    })
                }
            });

            $('.edit').colorbox({
                href: '/Cms/public/admin/site-options/languages/edit',
                overlayClose: true,
                width: '30%',
                height: '50%',
                close: 'x',
                onComplete: function () {
                    $.ajax({
                        url: '/Cms/public/admin/site-options/languages',
                        method: 'POST',
                        data: {
                            langId: $(this).parent().find('.lang_id').html(),
                            langKey: $(this).parent().find('.abbreviation').html(),
                            action: 'get-language'
                        }
                    }).done(function (msg) {
                        msg = JSON.parse(msg);
                        $('#langAbbreviation').val(msg.key);
                        $('#langVal').val(msg.value);
                        $('#langId').val(msg.id);
                        $('#oldKey').val(msg.key);
                    });

                    $('#edit-lang-btn').on('click', function () {
                        $.ajax({
                            method: 'POST',
                            url: '/Cms/public/admin/site-options/languages',
                            data: {
                                abbreviation: $('#langAbbreviation').val(),
                                language: $('#langVal').val(),
                                id: $('#langId').val(),
                                oldKey: $('#oldKey').val(),
                                action: 'update'
                            }
                        }).done(function (msg) {
                            $('#cboxLoadedContent').append(msg);
                            setTimeout(function () {
                                location.reload();
                            }, 800);
                        });
                    });
                }
            });

            $('.delete').on('click', function () {
                $.ajax({
                    method: 'POST',
                    url: '/Cms/public/admin/site-options/languages',

                    data: {
                        id: $(this).parent().find('.lang_id').html(),
                        action: 'delete'
                    }
                }).done(function (msg) {
                    if (msg) {
                        $('#language-list').after(msg);
                        setTimeout(function () {
                            location.reload();
                        }, 800);
                    } else {
                        location.reload();
                    }

                });
            });

            $('body').on('change', '#change-lang', function () {
                $.ajax({
                    url: '/Cms/public/admin/site-options/languages',
                    method: 'POST',
                    data: {
                        langId: $('#change-lang').val(),
                        action: 'change-language'
                    }
                }).done(function (msg) {
                    $('.options-container').remove(); //TODO Should replace only the table.
                    $('#site-options-aside').after(msg);
                    initAddLangActions();
                });
            });
        }

        initAddLangActions();
    }

    //*******CATEGORIES SET*******//

    else if($('#add-category').length > 0) {
        function categories() {
            $('#add-category').colorbox({
                href: '/Cms/public/admin/site-options/categories/create',
                overlayClose: true,
                width: '30%',
                height: '60%',
                close: 'x',
                onComplete: function () {
                    $.ajax({
                        url: '/Cms/public/admin/site-options/categories',
                        method: 'POST',
                        data: {
                            langId: $('#change-lang').val(),
                            action: 'get-cats-by-lang'
                        }
                    }).done(function (msg) {
                        var i, option;
                        msg = JSON.parse(msg);
                        for (i = 0; i < msg.length; i += 1) {
                            option = $('<option value=""></option>').attr('value', JSON.parse(msg[i]).cat_id).text(JSON.parse(msg[i]).cat_val);
                            $('#parent-category').append(option);
                        }
                    });
                    $('#create-category-btn').on('click', function () {
                        $.ajax({
                            method: 'POST',
                            url: '/Cms/public/admin/site-options/categories',
                            data: {
                                categoryKey: $('#category-key').val(),
                                categoryVal: $('#category-val').val(),
                                langId: $('#change-lang').val(),
                                parentKey: $('#parent-category').val(),
                                action: 'create-category'
                            }
                        }).done(function (msg) {
                            $('#cboxLoadedContent').append(msg);
                            setTimeout(function () {
                                location.reload();
                            }, 800);
                        });
                    });
                }
            });

            $('.edit').colorbox({
                href: '/Cms/public/admin/site-options/categories/edit',
                overlayClose: true,
                width: '30%',
                height: '60%',
                close: 'x',
                onComplete: function () {
                    $.ajax({
                        url: '/Cms/public/admin/site-options/categories',
                        method: 'POST',
                        data: {
                            catId: $(this).parent().find('.cat-id').html(),
                            catLang: $('#change-lang').val(),
                            action: 'get-category'
                        }
                    }).done(function (msg) {
                        var i, option,
                            category = JSON.parse(msg).category,
                            categories = JSON.parse(msg).categories;
                        $('#category-key').val(category.key);
                        $('#category-val').val(category.value);
                        $('#category-id').val(category.id);
                        for (i = 0; i < categories.length; i += 1) {
                            option = '<option value="' + categories[i].cat_key + '">' + categories[i].cat_val + '</option>';
                            $('#parent-category').append(option);
                        }
                        $('#parent-category option[value=' + category.parent_key + ']').attr('selected', 'selected');
                    });

                    $('#edit-category-btn').on('click', function () {
                        $.ajax({
                            url: '/Cms/public/admin/site-options/categories',
                            method: 'POST',
                            data: {
                                catId: $('#category-id').val(),
                                catKey: $('#category-key').val(),
                                catVal: $('#category-val').val(),
                                langId: $('#change-lang').val(),
                                parentId: $('#parent-category').val(),
                                action: 'edit-category'
                            }
                        }).done(function (msg) {
                            $('#cboxLoadedContent').append(msg);
                            setTimeout(function () {
                                location.reload();
                            }, 800);
                        });
                    });
                }
            });

            $('.delete').on('click', function () {
                $.ajax({
                    url: '/Cms/public/admin/site-options/categories/',
                    method: 'POST',
                    data: {
                        catKey: $(this).parent().find('.cat-key').html(),
                        action: 'delete-category'
                    }
                }).done(function (msg) {
                    $('.options-container').append(msg);
                    setTimeout(function () {
                        location.reload();
                    }, 800);
                });
            });

            $('#change-lang, #category-filter').on('change', function () {
                $.ajax({
                    url: '/Cms/public/admin/site-options/categories/',
                    method: 'POST',
                    data: {
                        languageId: $('#change-lang').val(),
                        categoryId: $('#category-filter').val(),
                        action: 'category-filter'
                    }
                }).done(function (msg) {
                    $('.options-container').replaceWith(msg);
                    //$('#category-list').length > 0
                    //    ? $('#category-list').replaceWith(msg)
                    //    : $('.options-container p.error').replaceWith(msg);
                    categories();
                });
            });
        }
        categories();
    }

    //***********SITE VARS OPTIONS***********//

    else if($('#add-var').length > 0) {
        function siteVars() {
            $('#add-var').colorbox({
                href: '/Cms/public/admin/site-options/site-vars/create',
                overlayClose: true,
                width: '30%',
                height: '60%',
                close: 'x',
                onComplete: function () {
                    $('#create-site-var-btn').on('click', function () {
                        $.ajax({
                            url: '/Cms/public/admin/site-options/site-vars',
                            method: 'POST',
                            data: {
                                svKey: $('#site-var-key').val(),
                                siteVar: $('#site-var').val(),
                                svCategory: $('#site-var-category').val(),
                                action: 'create-site-var'
                            }
                        }).done(function (msg) {
                            $('#cboxLoadedContent').append(msg);
                            setTimeout(function () {
                                location.reload();
                            }, 800);
                        });
                    })
                }
            });

            $('.edit').colorbox({
                href: '/Cms/public/admin/site-options/site-vars/edit',
                overlayClose: true,
                width: '30%',
                height: '60%',
                close: 'x',
                onComplete: function () {
                    $.ajax({
                        url: '/Cms/public/admin/site-options/site-vars',
                        method: 'POST',
                        data: {
                            svId: $(this).parent().find('.var-id').html(),
                            action: 'edit-sv'
                        }
                    }).done(function (msg) {
                        msg = JSON.parse(msg);
                        $('#site-var-id').val(msg.id);
                        $('#site-var-key').val(msg.key);
                        $('#site-var').val(msg.value);
                        $('#site-var-category option[value="' + msg.category_key + '"]').attr('selected', 'selected');
                    });

                    $('#edit-site-var-btn').on('click', function () {
                        $.ajax({
                            url: '/Cms/public/admin/site-options/site-vars',
                            method: 'POST',
                            data: {
                                svId: $('#site-var-id').val(),
                                svKey: $('#site-var-key').val(),
                                svVal: $('#site-var').val(),
                                svCat: $('#site-var-category').val(),
                                action: 'update-sv'
                            }
                        }).done(function (msg) {
                            $('#cboxLoadedContent').append(msg);
                            setTimeout(function () {
                                location.reload();
                            }, 800);
                        });
                    });
                }
            });

            $('body').on('click', '.delete', function () {
                $.ajax({
                    url: '/Cms/public/admin/site-options/site-vars',
                    method: 'POST',
                    data: {
                        svId: $(this).parent().find('.var-id').html(),
                        action: 'delete-sv'
                    }
                }).done(function (msg) {
                    $('.options-container').append(msg);
                    setTimeout(function () {
                        location.reload();
                    }, 800);
                });
            });

            $('body').on('change', '#change-lang, #sv-categories', function () {
                $.ajax({
                    url: '/Cms/public/admin/site-options/site-vars',
                    method: 'POST',
                    data: {
                        langId: $('#change-lang').val(),
                        svId: $('#sv-categories').val(),
                        action: 'sv-filter'
                    }
                }).done(function (msg) {
                    $('.options-container').replaceWith(msg);
                    siteVars();
                });
            });
        }
        siteVars();
    }

    //***********SECTION OPTIONS***********//

    else if($('#add-section').length > 0) {

        //cbOptions = {
        //    addSection: addSection,
        //    editSection: editSection,
        //    deleteSection: deleteSection,
        //    filterSections: filterSections,
        //    changeSectionVisibility: changeSectionVisibility,
        //    sectionSettings: sectionSettings
        //};

        function addSection() {
            $('#add-section').colorbox({
                href: '/Cms/public/admin/site-options/sections/create',
                overlayClose: true,
                width: '80%',
                height: '98%',
                close: 'x',
                onComplete: function () {
                    $.ajax({
                        url: '/Cms/public/admin/site-options/sections',
                        method: 'POST',
                        data: {
                            langId: $('#change-lang').val(),
                            action: 'create-section-get-language'
                        }
                    }).done(function (msg) {
                        var i, option;
                        msg = JSON.parse(msg);
                        for (i = 0; i < msg.length; i += 1) {
                            option = '<option value="' + msg[i].cat_key + '">' + msg[i].cat_val + '</option>';
                            $('#sec-category').append(option);
                            $('#sec-category option[value = "user_defined"]').attr("selected", "selected");
                        }
                    });

                    //$('#crete-section').on('click', function () {
                    //    //tinyMCE.triggerSave();
                    //    var sectionBody = tinyMCE.activeEditor.getBody();
                    //    $.ajax({
                    //        url: '/Cms/public/admin/site-options/sections',
                    //        method: 'POST',
                    //        data: {
                    //            catKey: $('#sec-category').val(),
                    //            secKey: $('#sec-key').val(),
                    //            secTitle: $('#sec-title').val(),
                    //            secDesc: $('#sec-desc').val(),
                    //            secBody: $(sectionBody).html(),
                    //            //secBody: $('#section-body').val(),
                    //            action: 'create-section'
                    //        }
                    //    }).done(function (msg) {
                    //        $('#cboxLoadedContent').append(msg);
                    //        setTimeout(function () {
                    //            location.reload();
                    //        }, 800);
                    //    });
                    //});
                }
            })
        }

        function editSection() {
            $('.edit').colorbox({
                href: '/Cms/public/admin/site-options/sections/edit',
                overlayClose: true,
                width: '80%',
                height: '90%',
                close: 'x',
                onComplete: function () {
                    var secId = $(this).parent().find('.id').html();
                    $.ajax({
                        url: '/Cms/public/admin/site-options/sections',
                        method: 'POST',
                        data: {
                            secId: $(this).parent().find('.id').html(),
                            langId: $('#change-lang').val(),
                            action: 'get-section-for-edit'
                        }
                    }).done(function (msg) {
                        //console.log(msg);
                        $('.create-form').replaceWith(msg);
                        //var i, option;
                        //msg = JSON.parse(msg);
                        //console.log(msg);
                        //for (i = 0; i < msg.categories.length; i += 1) {
                        //    option = '<option value="' + msg.categories[i].cat_key + '">' + msg.categories[i].cat_val + '</option>';
                        //    $('#sec-category').append(option);
                        //}
                        //$('#sec-category option[value="' + msg.section.category_key + '"]').attr('selected', 'selected');
                        //$('#sec-key').val(msg.section.key);
                        //$('#sec-title').val(msg.section.title);
                        //$('#sec-desc').val(msg.section.short_desc);
                        //tinyMCE.activeEditor.setContent(msg.section.body);
                        //$('#section-id').val(msg.section.id);
                        $('#update-section-btn').on('click', function () {
                            var sectionBody = tinyMCE.activeEditor.getBody();
                            $('#section-id').val(secId);
                            $('#update-section-form').submit();
                            //$inputs = $('.create-form input, .create-form textarea');
                            //for(var i = 0; i < $inputs.length; i += 1) {
                            //    $input = $($inputs[i]);
                            //    if($($input).hasClass('ext')) $input.attr('id');
                            //}

                            //$.ajax({
                            //    //url: '/Cms/public/admin/site-options/sections',
                            //    //method: 'POST',
                            //    //data: {
                            //    //    secId: secId,
                            //    //    secCat: $('#sec-category').val(),
                            //    //    secTitle: $('#sec-title').val(),
                            //    //    secDesc: $('#sec-desc').val(),
                            //    //    secBody: $(sectionBody).html(),
                            //    //    //extFields: $('#ext-fields-form').serialize(),
                            //    //    action: 'update-section'
                            //    //}
                            //}).done(function (msg) {
                            //    //console.log(msg);
                            //    //$('#cboxLoadedContent').append(msg);
                            //    //setTimeout(function () {
                            //    //    location.reload();
                            //    //}, 800);
                            //});
                        });

                        $('.cms-delete-resource').on('click', function() {
                            $.ajax({
                                url: '/Cms/public/admin/site-options/sections',
                                method: 'POST',
                                data: {
                                    resId: $('.cms-delete-resource').parent().prev().attr('name'),
                                    action: 'delete-resource'
                                }
                            }).done(function(msg) {
                                if(msg === 'deleted') $('.cms-current-res').val('current file: empty');
                            });
                        });
                    });

                }
            });
        }

        function deleteSection() {
            $('body').on('click', '.delete', function () {
                $.ajax({
                    url: '/Cms/public/admin/site-options/sections',
                    method: 'POST',
                    data: {
                        secId: $(this).parent().find('.id').html(),
                        action: 'delete-section'
                    }
                }).done(function (msg) {
                    $('.options-container').append(msg);
                    setTimeout(function () {
                        location.reload();
                    }, 800);
                });
            });
        }

        function filterSections() {
            $('body').on('change', '#change-lang, #section-categories', function () {
                $.ajax({
                    url: '/Cms/public/admin/site-options/sections',
                    method: 'POST',
                    data: {
                        langId: $('#change-lang').val(),
                        catId: $('#section-categories').val(),
                        action: 'section-filter'
                    }
                }).done(function (msg) {
                    $('#section-list, p.error').replaceWith(msg);
                    cbOptions.addSection();
                    cbOptions.editSection();
                    cbOptions.deleteSection();
                    cbOptions.sectionSettings();
                });
            });
        }

        function changeSectionVisibility() {
            $('body').on('click', '.visibility', function () {
                var visibility;
                if ($(this).find('img').attr('src') === '/Cms/public/images/allowed.png') {
                    visibility = 1;
                } else if ($(this).find('img').attr('src') === '/Cms/public/images/allowed.png') {
                    visibility = 0;
                }
                $.ajax({
                    url: '/Cms/public/admin/site-options/sections',
                    method: 'POST',
                    data: {
                        visibility: visibility,
                        secId: $(this).parent().find('.id').html(),
                        langId: $('#change-lang').val(),
                        catId: $('#section-categories').val(),
                        action: 'set-section-visibility'
                    }
                }).done(function (msg) {
                    $('#section-list').replaceWith(msg);
                    cbOptions.addSection();
                    cbOptions.editSection();
                    cbOptions.deleteSection();
                    cbOptions.sectionSettings();
                });
            });
        }

        function sectionSettings() {
            $('.sec-settings').colorbox({
                href: '/Cms/public/admin/site-options/sections/settings',
                overlayClose: true,
                width: '80%',
                height: '90%',
                close: 'x',
                onComplete: function() {
                    var secId = $(this).parent().find('.id').html();
                    $.ajax({
                        url: '/Cms/public/admin/site-options/sections/settings',
                        method: 'POST',
                        data: {
                            secId: secId,
                            action: 'get-section-settings'
                        }
                    }).done(function(msg) {
                        $('#cboxLoadedContent').append(msg);
                        $('#create-field').on('click', function() {
                            $('#section-settings button').removeClass('current');
                            $(this).addClass('current');
                            $.ajax({
                                url: '/Cms/public/admin/site-options/sections/settings',
                                method: 'POST',
                                data: {
                                    secId: secId,
                                    action: 'get-create-section-field-form'
                                }
                            }).done(function(msg) {
                                $('#section-fields-list, div.nosec').replaceWith(msg);
                                $('#create-new-field-btn').on('click', function() {
                                    $.ajax({
                                        url: '/Cms/public/admin/site-options/sections/settings',
                                        method: 'POST',
                                        data: {
                                            fLabel: $('#field-label').val(),
                                            fType: $('#field-type').val(),
                                            secId: secId,
                                            action: 'create-section-field'
                                        }
                                    }).done(function(msg) {
                                        //console.log(msg);
                                        location.reload();
                                    });
                                });
                            });
                        });
                        $('#list-fields').on('click', function() {
                            $('#section-list td.id:contains('+secId+')').parent().find('.sec-settings').click();
                        });

                        $('#section-fields-list .delete-section-field').on('click', function(){
                            $.ajax({
                                url: '/Cms/public/admin/site-options/sections/settings',
                                method: 'POST',
                                data: {
                                    extFieldId: $(this).parent().find('.id').html(),
                                    action: 'delete-ext-field'
                                }
                            }).done(function(msg){
                                console.log(msg);
                                $('#cboxLoadedContent').append(msg);
                                setTimeout(function(){
                                    location.reload();
                                }, 800);
                            });
                        });

                    });
                }
            });
        }

        cbOptions = {
            addSection: addSection,
            editSection: editSection,
            deleteSection: deleteSection,
            filterSections: filterSections,
            changeSectionVisibility: changeSectionVisibility,
            sectionSettings: sectionSettings
        };

        cbOptions.addSection();
        cbOptions.editSection();
        cbOptions.deleteSection();
        cbOptions.filterSections();
        cbOptions.changeSectionVisibility();
        cbOptions.sectionSettings();
    }
});
