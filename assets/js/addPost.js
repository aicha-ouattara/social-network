$.ajax({
    url : base_url+"addPost",
    type: "POST",
    dataType: "json",
    data : {
        'category': category,
        'question': question,
        'firstAnswer': firstAnswer,
        'secondAnswer': secondAnswer,
        'hashtags': hashtags,
        'imageToUpload': imageToUpload
    },
    success: function(data)
    {
        alert(data.status);
    }
});

