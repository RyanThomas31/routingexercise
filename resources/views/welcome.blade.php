<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    </head>
    <body class="antialiased">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <table id="postsTable" class="table table-bordered table-condensed table-striped">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Introduction Date</th>
                                <th>URL</th>
                            </tr>
                        </thead>
                    </table>
                </div>

            </div>
            <div class="row">
                <div class="col-sm-6">
                    <button type="button" id="addButton" class="btn btn-primary" onclick="addClick();">Add Product</button>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            Product Information
                        </div>
                        <div class="panel-body">
                        </div>
                        <div class="panel-footer">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="productname">Product Name</label>
                <input type="text" id="productname" class="form-control" />
            </div>
            <div class="form-group">
                <label for="introdate">Introduction Date</label>
                <input type="date" id="introdate" class="form-control" />
            </div>
            <div class="form-group">
                <label for="url">URL</label>
                <input type="url" id="url" class="form-control" />
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <button type="button" id="updateButton" class="btn btn-primary" onclick="updateClick();">Add</button>
                </div>
            </div>
        </div>

        <script>

            // Handle click event on Update button
            function updateClick() {
            }
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
                        postAddRow(post);
                        postBuildTableRow(post);
                        console.log(request);
                    },
                    error: function (request, message, error) {
                        handleException(request, message, error);
                    }
                    
                });
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
                    var ret =
                        "<tr>" +
                        "<td>" + post.name + "</td>" +
                        "<td>" + post.post + "</td>"
                        + "<td>" + post.cell + "</td>" +
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
            };

            $(document).ready(function () {
                postsList();
            });
        </script>
    </body>
</html>
