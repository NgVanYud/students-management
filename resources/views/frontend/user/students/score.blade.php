@extends('frontend.layouts.app')

@section('content')
    <div class="row justify-content-center align-items-center mb-3">
        <div class="col col-sm-10 align-self-center">
            <div class="card">
                <div class="card-header">
                    <strong>
                        {{ __('navs.frontend.user.score') }}
                    </strong>
                </div>

                <div class="card-body">
                    <div class="row mt-4">
                        <div class="col">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Num</th>
                                        <th>Subject</th>
                                        <th>Abbreviation</th>
                                        <th>Credit</th>
                                        <th>Score</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($tests as $test)
                                        <tr>
                                            <td>{{($loop->index) + 1}}</td>
                                            <td>{{$test->examination->subject->name}}</td>
                                            <td>{{$test->examination->subject->abbreviation}}</td>
                                            <td>{{$test->examination->subject->credit}}</td>
                                            <td>
                                                {{$test->students()->first()->result->correct_ans}}/
                                                {{$test->num_questions}}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div><!--col-->
                    </div><!--row-->
                </div><!--card body-->
            </div><!-- card -->
        </div><!-- col-xs-12 -->
    </div><!-- row -->
@endsection
