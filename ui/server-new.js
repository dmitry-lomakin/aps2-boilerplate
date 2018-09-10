define([
        "dojo/_base/declare",
        "dojo/has",
        "dojox/mvc/getPlainValue",
        "dojox/mvc/at",
        "dojox/mvc/getStateful",
        "dojo/when",
        "aps/Memory",
        "aps/View",
        "aps/ResourceStore"
    ],
    function (
        declare,
        has,
        getPlainValue,
        at,
        getStateful,
        when,
        Memory,
        View,
        Store
    ) {
        return declare(View, {
            init: function () {

                /* Declare the data sources */
                this.vpsModel = getStateful({
                    "aps": {
                        "type": "http://for93t.github.com/aps2-boilerplate/vps/1.0"
                    },
                    "name": "",
                    "os": "centos7"
                });

                /* Define the OS selection list */
                var oses = new Memory({
                    idProperty: "value",
                    data: [
                        {value: "centos7", label: "CentOS-7"},
                        {value: "windows2012", label: "Windows 2012 Server"}
                    ]
                });

                /* Define and return widgets */
                return [has('aps-bs') ? "aps/Panel" : "aps/Container", {
                    id: this.genId("srvNew_form")
                }, [
                    ["aps/FieldSet", {
                        id: this.genId("srvNew_properties"),
                        title: "General"
                    }, [
                        ["aps/TextBox", {
                            id: this.genId("srvNew_name"),
                            label: "Server Name",
                            value: at(this.vpsModel, "name"),
                            required: true
                        }],
                        ["aps/Select", {
                            id: this.genId("srvNew_os"),
                            label: "Operating System",
                            store: oses,
                            value: at(this.vpsModel, "os"),
                            required: true
                        }]
                    ]]
                ]];

            },    // End of Init

            /* Create handlers for the navigation buttons */

            onCancel: function () {
                aps.apsc.gotoView(has('aps-bs') ? "servers" : "servers-ccpv1");
            },

            onSubmit: function () {
                aps.context.subscriptionId = aps.context.vars.management.aps.subscription;

                var vpsStore = new Store({
                    apsType: "http://for93t.github.com/aps2-boilerplate/vps/1.0",
                    target: "/aps/2/resources/" + aps.context.vars.management.aps.id + "/vpses"
                });
                when(vpsStore.put(getPlainValue(this.vpsModel)),
                    function () {
                        aps.apsc.gotoView(has('aps-bs') ? "servers" : "servers-ccpv1");
                    }
                );
            }

        });    // End of Declare
    });        // End of Define
