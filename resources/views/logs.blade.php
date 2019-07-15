<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
<style type="text/css">
    pre {
        font-size: 52%!important
    }
</style>
<head>
    <title>Api Logs</title>
</head>
<?php
$collection = \DB::table('api_logs')->orderBy('created_at', 'desc')->paginate(50);

?>

<div id="accordion" role="tablist" style=" margin: 0 auto; margin-top: 3%">
    <a href="logs?clear=true" class="btn btn-primary" style="margin-bottom: 10px">Clear Log</a>
@foreach( $collection as $model )
    <div class="card" style="margin-bottom: 5px">
        <div class="card-header" role="tab" id="headingOne">
            <h5 class="mb-0">
                <a data-toggle="collapse" href="#collapseOne{{$model->id}}" aria-expanded="false" aria-controls="collapseOne{{$model->id}}" class="collapsed" style="display: block">
                    {{ $model->url }} Created At: {{ date('d-m-Y h:i a', strtotime($model->created_at)) }}
                </a>
            </h5>
        </div>

        <div id="collapseOne{{$model->id}}" class="collapse" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion" style="">
            <div class="card-body">

                <h3>Request JSON</h3>
                <pre>
                    <?php
                        try {
                            echo json_encode(unserialize($model->json), JSON_PRETTY_PRINT);
                        } catch (\Exception $e) {

                        }
                    ?>
                </pre>
                <h3>Request JSON</h3>
                <pre>
                    <?php
                        try {
                            echo json_encode(unserialize($model->res), JSON_PRETTY_PRINT);
                        } catch (\Exception $e) {

                        }
                    ?>
                </pre>
            </div>
        </div>
    </div>
    @endforeach
        {{ $collection->appends(request()->all())->links() }}
</div>
