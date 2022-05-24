<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" rel="stylesheet"></link>
        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    </head>
    <body class="antialiased">
        <input type="hidden" id="postid" value="0" />
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <table id="postsTable" class="table table-bordered table-condensed table-striped">
                        <thead>
                            <tr>
                                <th>Edit</th>
                                <th>Name</th>
                                <th>Post</th>
                                <th>Cell</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                    </table>
                </div>

            </div>
            <div class="row">
                <div class="col-sm-6">
                    <button type="button" id="addButton" class="btn btn-primary" onclick="addClick();">Add Post</button>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            Post Info
                        </div>
                        <div class="panel-body">
                        </div>
                        <div class="panel-footer">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" class="form-control" />
            </div>
            <div class="form-group">
                <label for="postmessage">Post</label>
                <input type="text" id="postmessage" class="form-control" />
            </div>
            <div class="form-group">
                <label for="cell">Cell</label>
                <input type="cell" id="cell" class="form-control" />
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <button type="button" id="updateButton" class="btn btn-primary" onclick="updateClick();">Add</button>
                </div>
            </div>
        </div>

        <script>

            // Handle click event on Add button
            function addClick() {
            }

            function postsList() {
                $.ajax({
                    url: "http://127.0.0.1:8000/api/posts",
                    method: "GET",
                    dataType: "json",
                    success: function(posts, request) {
                        fetchPostsSuccessfully(posts);
                    },
                    error: function (request, message, error) {
                        handleException(request, message, error);
                    }
                    
                });
            };

            function fetchPostsSuccessfully(posts) {
                    // Iterate over the collection of data
                    $.each(posts, function (index, post) {
                        // Add a row to the post table
                        postAddRow(post);
                    });
            }
            function postAddRow(post) {
                // Check if <tbody> tag exists, add one if not
                if ($("#postsTable tbody").length == 0) {
                    $("#postsTable").append("<tbody></tbody>");
                }
                // Append row to <table>
                $("#postsTable tbody").append(
                    postBuildTableRow(post));
            }
            function postBuildTableRow(post) {
                console.log(post);
                var ret =
                    "<tr>" +
                    "<td>" + 
                        "<button type='button' " + "onclick='postGet(this);' " + "class='btn btn-default' " + "data-id='" + post.id + "'>" 
                            + "<span class='fa-solid fa-file-pen' />" + 
                        "</button>" + 
                    "</td>" +
                    "<td>" + post.name + "</td>" +
                    "<td>" + post.post + "</td>" + 
                    "<td>" + post.cell + "</td>" +
                    "<td>" +
                    "<button type='button' " +
                        "onclick='postDelete(this);' " +
                        "class='btn btn-default' " +
                        "data-id='" + post.id + "'>" +
                        "<span class='fa-solid fa-trash' />" +
                    "</button>" +
                    "</td>" +
                    "</tr>";
                return ret;
            }

            function handleException(request, message, error) {
                    var msg = "";
                    msg += "Code: " + request.status + "\n";
                    msg += "Text: " + request.statusText + "\n";
                    if (request.responseJSON != null) {
                        msg += "Message" + request.responseJSON.Message + "\n";
                    }
                    alert(msg);
                }
            function postGet(pst) {
                // Get post id from data- attribute
                var id = $(pst).data("id");
                // Store post id in hidden field
                $("#postid").val(id);
                // Call Web API to get a list of Posts
                $.ajax({
                    url: "http://127.0.0.1:8000/api/post/" + id,
                    type: 'GET',
                    dataType: 'json',
                    success: function (post) {
                        postToFields(post);
                        
                        // Change Update Button Text
                        $("#updateButton").text("Update");
                    },
                    error: function (request, message, error) {
                        handleException(request, message, error);
                    }
                });
            };
            function postToFields(post) {
                $("#name").val(post.Name);
                $("#postmessage").val(post.Post);
                $("#cell").val(post.Cell);
            };

            var Post = {
                Name: "",
                Post: "",
                Cell: ""
            }


            // Handle click event on Update button
            function updateClick() {
                // Build post object from inputs
                Post = new Object();
                Post.Name = $("#name").val();
                Post.Post = $("#postmessage").val();
                Post.Cell = $("#cell").val();
                if ($("#updateButton").text().trim() == "Add") {
                    postAdd(Post);
                } else {
                    postUpdate(Post);
                }
            }

            function postAdd(post) {
                $.ajax({
                    url: "http://127.0.0.1:8000/api/addBlogs",
                    type: 'POST',
                    contentType: "application/json;charset=utf-8",
                    data: JSON.stringify(post),
                    success: function (post) {
                        postAddSuccess(post);
                    },
                    error: function (request, message, error) {
                        handleException(request, message, error);
                    }
                });
            }

            function postAddSuccess(post) {
                postAddRow(post);
                formClear();
            }

            function postUpdate(post) {
                $.ajax({
                    url: "http://127.0.0.1:8000/api/updatePost/",
                    type: 'PUT',
                    contentType: 
                    "application/json;charset=utf-8",
                    data: JSON.stringify(post),
                    success: function (post) {
                    postUpdateSuccess(post);
                    },
                    error: function (request, message, error) {
                    handleException(request, message, error);
                    }
                });
            }

            function postUpdateSuccess(post) {
                postUpdateInTable(post);
            }

            function postUpdateInTable(post) {
                // Find Post in <table>
                var row = $("#postsTable button[data-id='" + post.id + "']").parents("tr")[0];
                
                // Add changed post to table
                $(row).after(postBuildTableRow(post));
                
                // Remove original post
                $(row).remove();
                formClear();  // Clear form fields
                
                // Change Update Button Text
                $("#updateButton").text("Add");
            }

            function postDelete(ctl) {
                var id = $(ctl).data("id");
                        
                $.ajax({
                    url: "http://127.0.0.1:8000/api/deletePost/" + id,
                    type: 'DELETE',
                    success: function (post) {
                        $(ctl).parents("tr").remove();
                    },
                    error: function (request, message, error) {
                        handleException(request, message, error);
                    }
                });
            }


            function formClear() {
            $("#name").val("");
            $("#postmessage").val("");
            $("#cell").val("");
            }
            function addClick() {
            formClear();
            }

            $(document).ready(function () {
                postsList();
            });
        </script>
    </body>
</html>
