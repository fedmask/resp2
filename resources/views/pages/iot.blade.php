@extends('layouts.app')
@extends('includes.template_head')

@section('pageTitle', 'IoT')
@section('content')
    <!--PAGE CONTENT -->
    <!--utilità per i pazienti Ospedali - Linee guida -->
    <div id="content">
        <div class="inner" >
            <div class="col-lg-12"><h1><center> IoT </center></h1>
            </div>
            <div class="accordion ac" id="accordionUtility">
                <div class="accordion-group">
                    <div class="accordion-heading centered">
                        <div class = "col-lg-12">
                            <div  class = "col-lg-4">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordionUtility" href="#VoxTester">
                                    <h3>VoxTester</h3>
                                </a>
                            </div>
                            <div  class = "col-lg-4">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordionUtility" href="#HbMeter">
                                    <h3>HbMeter</h3>
                                </a>
                            </div>

                            <div  class = "col-lg-4">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordionUtility" href="#Kardia">
                                    <h3>Kardia</h3>
                                </a>
                            </div>
                        </div><!--col-lg-12-->
                    </div><!--accordion- group heading centered-->

                    <!--Accordition VoxTester-->
                    <div id="VoxTester" class="accordion-body collapse">
                        <div class="accordion-inner">
                            <div class ="row">
                                <h3><center>VoxTester</center></h3>

                                <!--Accordion HbMeter-->
                                <div class="accordion-group" id = "ac-Osp">
                                    <div class="col-lg-12">
                                        <div class="panel warning" >

                                        </div><!--panel warning-->

                                    </div><!--col-lg-12-->
                                </div><!--accordion-group ac-Osp-->
                            </div><!--row-->
                        </div><!--accordion inner-->
                    </div><!--accordion-body collapse-->

                    <div id="HbMeter" class="accordion-body collapse">
                        <div class="accordion-inner">
                            <div class ="row">
                                <h3><center>HbMeter</center></h3>

                                <!--Accordion HbMeter-->
                                <div class="accordion-group" id = "ac-Osp">
                                    <div class="col-lg-12">
                                        <div class="panel warning" >

                                            <div class = "panel-body">
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Giorno dell'analisi</th>
                                                            <th>Valore dell'analisi</th>
                                                        </tr>
                                                        @foreach($hbmeters as $hbm)
                                                            <tr>
                                                                <td>{{ $hbm->id_hbmeter }}</td>
                                                                <td>{{ $hbm->analisi_giorno }}</td>
                                                                <td>{{ $hbm->analisi_valore }}</td>
                                                            </tr>
                                                        @endforeach

                                                    </table>

                                                </div>
                                            </div>

                                        </div><!--panel warning-->

                                    </div><!--col-lg-12-->
                                </div><!--accordion-group ac-Osp-->
                            </div><!--row-->
                        </div><!--accordion inner-->
                    </div><!--accordion-body collapse-->

                    <div id="Kardia" class="accordion-body collapse">
                        <div class="accordion-inner">
                            <div class ="row">
                                <h3><center>Kardia</center></h3>

                                <!--Accordion Ospedali-->
                                <div class="accordion-group" id = "ac-Osp">
                                    <div class="col-lg-12">
                                        <div class="panel warning" >



                                        </div><!--panel warning-->

                                    </div><!--col-lg-12-->
                                </div><!--accordion-group ac-Osp-->
                            </div><!--row-->
                        </div><!--accordion inner-->
                    </div><!--accordion-body collapse-->

                </div><!--accordion group-->
            </div><!--accordion Utility-->

        </div><!--inner-->

    </div> <!--content-->
    <!--END PAGE CONTENT -->
@endsection