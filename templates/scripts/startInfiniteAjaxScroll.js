/* 
 * Dieses Skript initialisiert alle Javascripts auf dieser Seite
 */

/*
 * AJAX Scrolling für Gallery
 */
var ias = $('#albumcontent').ias({
                    container:  '#album',
                    item:       '.albumimg',
                    pagination: '.MarkupPagerNav',
                    next:       '.MarkupPagerNavNext a',
                    delay:      '0',
                    negativeMargin: 500
                });
                // Adds a loader image which is displayed during loading
                ias.extension(new IASSpinnerExtension());
                // Adds a text when there are no more pages left to load
                ias.extension(new IASNoneLeftExtension());