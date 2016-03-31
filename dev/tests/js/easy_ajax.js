
casper.test.begin("EasyAjax.Request Class", 4, function suite(test) {
    casper.start("http://127.0.0.1/easy-ajax/", function() {
        test.assertHttpStatus(200);
        test.assertEval(function () {
            return typeof EasyAjax.Request != "undefined";
        });
    });
    casper.then(function () {
        //test empty
        test.assertEvalEquals(function () {
            return EasyAjax.Request.prototype.prepareParams({});
        }, {
            "easy_ajax": 1
        });

        //test with params
        test.assertEvalEquals(function () {
            return EasyAjax.Request.prototype.prepareParams({
                "action_content": ["block1", "block2"],
                "custom_content": ["block3"]
            });
        }, {
            "easy_ajax": 1,
            "action_content[0]": "block1",
            "action_content[1]": "block2",
            "custom_content[0]": "block3"
        });
    });
    casper.run(function() {
        test.done();
    });
});

