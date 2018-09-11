define([
        "dojo/_base/declare",
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
                        "type": "http://for93t.github.com/aps2-boilerplate/vps/1.0",
                    },
                    "name": "",
                    "os": "centos7"
                });

                this.vpsStore = new Store({
                    apsType: "http://for93t.github.com/aps2-boilerplate/vps/1.0",
                    target: "/aps/2/resources"
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
                return ["aps/Panel", {
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

            },

            onContext: function() {
                var self = this;

                /* Request the list of offers and list of users. Initialize data sources. */
                when(self.vpsStore.get(aps.context.vars.server.aps.id))
                    .then(function (vpsData) {
                        self.vpsModel.set("name", vpsData.name);
                        self.vpsModel.set("os", vpsData.os);
                        self.vpsModel.set("aps", vpsData.aps);

                        aps.apsc.hideLoading();
                    });
            },

            /* Create handlers for the navigation buttons */

            onCancel: function () {
                aps.apsc.gotoView("servers");
            },

            onSubmit: function () {
                when(this.vpsStore.put(getPlainValue(this.vpsModel)),
                    function () {
                        aps.apsc.gotoView("servers");
                    }
                );
            }

        });
    });
