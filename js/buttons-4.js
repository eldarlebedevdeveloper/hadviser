(function() {
    tinymce.create("tinymce.plugins.green_button_plugin", {
        init : function(ed, url) {   
            ed.addButton("blockquote_custom_1", {
                title : "Цитата №1",
                cmd : "blockquote_custom_1",
                image : "/wp-content/themes/hairadviser/i/bq-1-min.png"
            });
            ed.addCommand("blockquote_custom_1", function() {
                var selected_text = ed.selection.getContent();
               var return_text = '[bq_1]' + selected_text + '[/bq_1]';
                ed.execCommand("mceInsertContent", 0, return_text);
            });
            ed.addButton("blockquote_custom_2", {
                title : "Цитата №2",
                cmd : "blockquote_custom_2",
                image : "/wp-content/themes/hairadviser/i/bq-2-min.png"
            });
            ed.addCommand("blockquote_custom_2", function() {
                var selected_text = ed.selection.getContent();
                var return_text = '[bq_2]' + selected_text + '[/bq_2]';
                ed.execCommand("mceInsertContent", 0, return_text);
            });
            ed.addButton("blockquote_custom_3", {
                title : "Цитата №3", 
                cmd : "blockquote_custom_3",
                image : "/wp-content/themes/hairadviser/i/bq-3-min.png"
            });
            ed.addCommand("blockquote_custom_3", function() {
                var selected_text = ed.selection.getContent();
                var return_text = '[bq_3]' + selected_text + '[/bq_3]';
                ed.execCommand("mceInsertContent", 0, return_text);
            });
            ed.addButton("blockquote_custom_4", {
                title : "Вопрос",
                cmd : "blockquote_custom_4", 
                image : "/wp-content/themes/hairadviser/i/bq-4-min.png"
            }); 
            ed.addCommand("blockquote_custom_4", function() {
                var selected_text = ed.selection.getContent();
                var return_text = '[bq_4]' + selected_text + '[/bq_4]';
                ed.execCommand("mceInsertContent", 0, return_text);
            }); 
            // ed.addButton("blockquote_custom_5", {
            //     title : "Описание артиста", 
            //     cmd : "blockquote_custom_5",
            //     image : "/wp-content/themes/hairadviser/i/bq-4-min.png"
            // });
            // ed.addCommand("blockquote_custom_5", function() {
            //     var selected_text = ed.selection.getContent();
            //     var return_text = '[bq_5]' + selected_text + '[/bq_5]';
            //     ed.execCommand("mceInsertContent", 0, return_text);
            // });
        },

        createControl : function(n, cm) {
            return null;
        },

        getInfo : function() {
            return {
                longname : "Extra Buttons",
                author : "Narayan Prusty",
                version : "1"
            };
        }
    });

    tinymce.PluginManager.add("green_button_plugin", tinymce.plugins.green_button_plugin);
})();