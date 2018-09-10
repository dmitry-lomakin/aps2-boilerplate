define([
    "dojo/_base/declare",
    "dojo/has",
    "aps/View",
    "aps/ResourceStore"
], function (
    declare,
    has,
    View,
    Store
) {
    return declare(View, {
        init: function () {

            /* Define the data store */
            var vpsStore = new Store({
                apsType: "http://for93t.github.com/aps2-boilerplate/vps/1.0",
                target: "/aps/2/resources/"
            });
            /* Define a handler for the *New* button click */
            var add = function () {
                /* Start the process of creating a VPS by going to the relevant view */
                aps.apsc.gotoView(has('aps-bs') ? "server-new" : "server-new-ccpv1");
            };
            /* Define and return widgets */
            return ["aps/Grid", {
                id: this.genId("srv_grid"),
                store: vpsStore,
                columns: [{
                    field: "name",
                    name: "Name"
                }, {
                    field: "os",
                    name: "Operating System"
                }
                ]
            }, [
                ["aps/Toolbar", [
                    ["aps/ToolbarButton", {
                        id: this.genId("srv_new"),
                        iconClass: "fa-plus",
                        type: "primary",
                        label: "New",
                        onClick: add
                    }]
                ]]
            ]];

        }, // End of Init

        onContext: function () {
            this.byId("srv_grid").refresh();
            aps.apsc.hideLoading();
        },

        onHide: function () {
            this.byId("srv_new").cancel();
        }

    });
});
