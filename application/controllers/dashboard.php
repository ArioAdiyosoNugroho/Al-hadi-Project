<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_dashboard');
    }

    public function index()
    {
        $maxPoint = $this->M_dashboard->max_possible_point();
        if ($maxPoint <= 0) $maxPoint = 100;

        // ── Stat cards
        $totalClasses         = $this->M_dashboard->total_classes();
        $totalAspects         = $this->M_dashboard->total_aspects();
        $assessmentsThisMonth = $this->M_dashboard->total_assessments_this_month();
        $assessmentsToday     = $this->M_dashboard->total_assessments_today();
        $avgPointThisMonth    = $this->M_dashboard->avg_point_this_month();
        $classesAssessed      = $this->M_dashboard->classes_assessed_this_month();

        // ── Chart data
        $weeklyTrend   = $this->M_dashboard->chart_weekly_trend();
        $avgPerClass   = $this->M_dashboard->chart_avg_point_per_class();
        $conditionDist = $this->M_dashboard->chart_condition_distribution();
        $monthlyTrend  = $this->M_dashboard->chart_monthly_trend();

        // FIX: key yang benar adalah condition_status (bukan condition_value)
        $condMap = ['bersih' => 0, 'cukup' => 0, 'kotor' => 0];
        foreach ($conditionDist as $c) {
            $key = strtolower($c->condition_status);
            if (isset($condMap[$key])) $condMap[$key] = (int)$c->total;
        }

        // ── Table data
        $ranking           = $this->M_dashboard->ranking_classes_this_month();
        $recentAssessments = $this->M_dashboard->recent_assessments(8);

        $data = [
            'title'   => 'Dashboard',
            'content' => 'pages/dashboard/index',

            // stat cards
            'total_classes'        => $totalClasses,
            'total_aspects'        => $totalAspects,
            'assessments_month'    => $assessmentsThisMonth,
            'assessments_today'    => $assessmentsToday,
            'avg_point_month'      => $avgPointThisMonth,
            'classes_assessed'     => $classesAssessed,
            'max_point'            => $maxPoint,
            'avg_percent'          => $maxPoint > 0 ? round(($avgPointThisMonth / $maxPoint) * 100) : 0,

            // chart json
            'chart_weekly'         => json_encode($weeklyTrend),
            'chart_avg_per_class'  => json_encode($avgPerClass),
            'chart_condition'      => json_encode($condMap),
            'chart_monthly'        => json_encode($monthlyTrend),

            // tables
            'ranking'              => $ranking,
            'recent_assessments'   => $recentAssessments,

            // meta
            'bulan_ini'            => date('F Y'),
            'classes_not_assessed' => max(0, $totalClasses - $classesAssessed),
        ];

        $this->load->view('layouts/main', $data);
    }
}
