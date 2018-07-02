(function () {
    tinymce.create('tinymce.plugins.wp_voting', {
        init: function (ed, url) {
            ed.addButton('wp_voting', {
                title: 'Contest Button',
                image: url + '../img/voting.png',
                onclick: function () {
                    var contest_id = prompt("Enter Contest ID", "");

                    if (contest_id != null && contest_id != '') {
                        ed.execCommand('mceInsertContent', false, '[WP_VOTING "' + contest_id + '"][/WP_VOTING]');
                    } else {
                        ed.execCommand('mceInsertContent', false, '[WP_VOTING "1"][/WP_VOTING]');
                    }
                }
            });
        },
        createControl: function (n, cm) {
            return null;
        },
        getInfo: function () {
            return {
                longname: "WP VOTING",
                author: 'Greg OLIVIER',
                authorurl: 'https://github.com/greg-olivier',
                infourl: '',
                version: "1.0"
            };
        }
    });
    tinymce.PluginManager.add('wp_voting', tinymce.plugins.wp_voting);
})();