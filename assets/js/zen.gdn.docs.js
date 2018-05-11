var GDP = new Vue({
    el: '#gdp',
    delimiters: ['${', '}'],
    data: {
        processed: false,
        steep: 0,
        count: 0,
    },
    methods: {
        parse: function () {
            $('span[item-id]').removeClass('processed');
            this.processed = true;
            this.go();
        },
        go: function () {
            var $this = this;
            $.ajax({
                type: 'post',
                url: location.origin + '/zen/gdp/api/parser/docs',
                data: {steep:$this.steep},
                success: function (json) {
                    json = JSON.parse(json);
                    $this.mark(json.id);
                    if(json.steep == json.count - 1) {
                        $this.processed = false;
                        $this.steep = 0;
                        $this.count = 0;
                    } else {
                        $this.steep = json.steep + 1;
                        $this.count = json.count;
                        $this.go();
                    }
                }
            });
        },
        mark: function (id) {
            $('span[item-id='+id+']').addClass('processed');
        }
    }
});

