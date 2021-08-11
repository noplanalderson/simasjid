var options = {
    url: baseURI + "/database-mustahik/json-data",

    getValue: "data",
    theme: "plate-dark",
    list: {
      showAnimation: {
        type: "slide", //normal|slide|fade
        time: 100,
        callback: function() {}
      },
      hideAnimation: {
        type: "fade", //normal|slide|fade
        time: 100,
        callback: function() {}
      },
      match: {
        enabled: true
      }
    }
};

    $("#atas_nama").easyAutocomplete(options);