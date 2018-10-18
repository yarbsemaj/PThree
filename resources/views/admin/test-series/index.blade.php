@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Test Series</div>
                    <div class="card-body">
                        <a href="{{ url('/admin/test-series/create') }}" class="btn btn-success btn-sm" title="Add New TestSeries">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New
                        </a>

                        <form method="GET" action="{{ url('/admin/test-series') }}" accept-charset="UTF-8" class="form-inline my-2 my-lg-0 float-right" role="search">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" placeholder="Search..." value="{{ request('search') }}">
                                <span class="input-group-append">
                                    <button class="btn btn-secondary" type="submit">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </form>

                        <br/>
                        <br/>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Title</th><th>Url Token</th><th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($testseries as $item)
                                    <tr>
                                        <td>{{ $item->title }}</td><td>{{ $item->url_token }}</td>
                                        <td>
                                            <a href="{{ url('/admin/test-series/' . $item->id) }}" title="View Test Series"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                            <a href="{{ url('/admin/test-series/' . $item->id . '/edit') }}" title="Edit Test Series"><button class="btn btn-primary btn-sm"><i class="far fa-edit" aria-hidden="true"></i> Edit</button></a>

                                            <form method="POST" action="{{ url('/admin/test-series' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete Test Series" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="far fa-trash-alt" aria-hidden="true"></i> Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $testseries->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
