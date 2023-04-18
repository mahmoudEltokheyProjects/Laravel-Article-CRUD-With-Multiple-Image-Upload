<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel Article CRUD With Multiple Image Upload</title>
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
        <!-- Font-awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    </head>
    <body>

        <div class="container" style="margin-top: 50px;">
            <!-- ++++++++++++++++++++++++ Add Message ++++++++++++++++++++++++ -->
            @if (session('success'))
                <div class="col-sm-12">
                    <div class="alert  alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
                </div>
            @endif
            <h3 class="text-center text-danger mb-5"><b>Laravel Article CRUD With Multiple Image Upload</b> </h3>
            {{-- ++++++++++++++++++++ "Add New Post" Button ++++++++++++++++++++ --}}
            <a href="/create" class="btn btn-success">Add New Post</a>
            {{-- ++++++++++++++++++++ "Delete All Selected" Button ++++++++++++++++++++ --}}
            <button class="btn btn-danger" id="deleteAllSelectedRecord">Delete All Selected</button>
            {{-- ++++++++++++++++++++ Table ++++++++++++++++++++ --}}
            <table class="table table-bordered table-hover mt-3">
                <thead>
                  <tr>
                    <th>
                        <input type="checkbox" name="" id="select_all_ids">
                    </th>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Description</th>
                    <th>Cover</th>
                    <th>Update</th>
                    <th>Delete</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($posts as $post)
                        <tr id="post_ids{{ $post->id }}">
                            {{-- +++++++++++++++++++ Checkbox +++++++++++++++++++ --}}
                            <td>
                                <input type="checkbox" name="ids" class="checkbox_ids" id="" value="{{ $post->id }}" />
                            </td>
                            <th scope="row">{{ $post->id }}</th>
                            <td>{{ $post->title }}</td>
                            <td>{{ $post->author }}</td>
                            <td>{{ $post->body }}</td>
                            <td>
                                <img src="cover/{{ $post->cover }}" class="img-responsive" style="max-height:100px; max-width:100px" alt="" srcset="">
                            </td>
                            <td>
                                <a href="/edit/{{ $post->id }}" class="btn btn-primary">Update</a>
                            </td>
                            <td>
                                <form action="/delete/{{ $post->id }}" method="post">
                                    <button class="btn btn-danger" onclick="return confirm('Are you sure?');" type="submit">Delete</button>
                                    @csrf
                                    @method('delete')
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
              </table>
        </div>
        {{-- +++++++++++++++++++++++++++++++ Scripts +++++++++++++++++++++++++++++++++++++++++++++ --}}
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>

        <script>
            $(function(e){
                $('#select_all_ids').click(function(){
                    // "Select All" checkboxs When clicked on "first Checkbox" in table
                    $('.checkbox_ids').prop('checked', $(this).prop('checked') );
                });
                // When clicked on "deleteAllSelectedRecord" Button
                $('#deleteAllSelectedRecord').click(function(){
                    // e.preventDefault();
                    var all_ids = [];
                    // Get "All Selected Checkboxes"
                    $('input:checkbox[name=ids]:checked').each(function(){
                        // Push "All Selected Checkboxes" value And Store Them "all_ids" Array
                        all_ids.push( $(this).val() );
                    });

                    $.ajax({
                        url:"{{ route('post.delete') }}",
                        type:"DELETE",
                        data:{
                            ids:all_ids,
                            _token:'{{ csrf_token() }}'
                        },
                        success:function(response){
                            $.each(all_ids,function(key,val)
                            {
                                $('#post_ids'+val).remove();
                            })
                        }
                    });

                });
            });
        </script>


    </body>
</html>
