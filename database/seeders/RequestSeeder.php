<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Request;
use App\Models\ApprovalStep;
use App\Models\User;
use Carbon\Carbon;

class RequestSeeder extends Seeder
{
    public function run(): void
    {
        $year = date('Y');
        $mchungaji = User::where('email', "KKKT-AGAPE-{$year}-0001@kkkt-agape.org")->first();
        $mhasibu = User::where('email', "KKKT-AGAPE-{$year}-0002@kkkt-agape.org")->first();

        $mchungajiId = $mchungaji?->id ?? 1;
        $mhasibuId = $mhasibu?->id ?? 2;

        $requests = [
            // ── FULLY APPROVED: 2-level approval complete with signatures ──
            [
                'request_number' => 'REQ2025001',
                'title' => 'Ununuzi wa Mikrofoni Mipya',
                'description' => 'Mikrofoni iliyopo imezeeka na inazalisha sauti isiyo safi. Tunahitaji ununuzi wa mikrofoni 4 mpya za ubora wa juu pamoja na vifaa vyake.',
                'department' => 'Huduma za Sauti',
                'amount_requested' => 800000,
                'amount_approved' => 750000,
                'status' => 'Imeidhinishwa',
                'approval_notes' => 'Ombi limeidhinishwa. Nunua mikrofoni za bei nafuu lakini za ubora.',
                'requested_date' => Carbon::now()->subMonths(3)->format('Y-m-d'),
                'approved_date' => Carbon::now()->subMonths(3)->addDays(5)->format('Y-m-d'),
                'requested_by' => $mhasibuId,
                'approved_by' => $mchungajiId,
                'current_level' => 2,
                'max_level' => 2,
                'created_at' => Carbon::now()->subMonths(3),
                'updated_at' => Carbon::now()->subMonths(3)->addDays(5),
            ],
            [
                'request_number' => 'REQ2025002',
                'title' => 'Ukarabati wa Paa la Kanisa',
                'description' => 'Paa la kanisa linadondosha maji wakati wa mvua. Kunahitajika ukarabati wa haraka ili kuzuia uharibifu zaidi wa jengo.',
                'department' => 'Ujenzi na Matengenezo',
                'amount_requested' => 3000000,
                'amount_approved' => 2500000,
                'status' => 'Imeidhinishwa',
                'approval_notes' => 'Ombi limeidhinishwa kwa TZS 2,500,000. Kamati ya ujenzi itasimamia kazi.',
                'requested_date' => Carbon::now()->subMonths(4)->format('Y-m-d'),
                'approved_date' => Carbon::now()->subMonths(4)->addDays(3)->format('Y-m-d'),
                'requested_by' => $mhasibuId,
                'approved_by' => $mchungajiId,
                'current_level' => 2,
                'max_level' => 2,
                'created_at' => Carbon::now()->subMonths(4),
                'updated_at' => Carbon::now()->subMonths(4)->addDays(3),
            ],

            // ── PENDING LEVEL 1: Mhasibu approved, waiting for Mchungaji ──
            [
                'request_number' => 'REQ2025005',
                'title' => 'Msaada kwa Familia ya Ndugu Mwanachama Aliyefariki',
                'description' => 'Ndugu John Mtani amefariki. Familia yake inahitaji msaada wa fedha kwa matumizi ya mazishi na kusaidia watoto wake 4 walioachwa.',
                'department' => 'Huduma za Kijamii',
                'amount_requested' => 500000,
                'amount_approved' => null,
                'status' => 'Inasubiri',
                'approval_notes' => null,
                'requested_date' => Carbon::now()->subDays(5)->format('Y-m-d'),
                'approved_date' => null,
                'requested_by' => $mhasibuId,
                'approved_by' => null,
                'current_level' => 1,
                'max_level' => 2,
                'created_at' => Carbon::now()->subDays(5),
                'updated_at' => Carbon::now()->subDays(3),
            ],
            // ── PENDING LEVEL 2: Mhasibu approved, Mchungaji pending ──
            [
                'request_number' => 'REQ2025006',
                'title' => 'Projector kwa Shule ya Jumapili',
                'description' => 'Tunahitaji projector ili kuweza kuonyesha video za kielimu kwa watoto wakati wa masomo ya Jumapili. Itasaidia sana katika kufundisha.',
                'department' => 'Shule ya Jumapili',
                'amount_requested' => 600000,
                'amount_approved' => null,
                'status' => 'Inasubiri',
                'approval_notes' => null,
                'requested_date' => Carbon::now()->subDays(3)->format('Y-m-d'),
                'approved_date' => null,
                'requested_by' => $mhasibuId,
                'approved_by' => null,
                'current_level' => 2,
                'max_level' => 2,
                'created_at' => Carbon::now()->subDays(3),
                'updated_at' => Carbon::now()->subDays(2),
            ],

            // ── REJECTED: Mhasibu rejected at level 1 ──
            [
                'request_number' => 'REQ2025007',
                'title' => 'Fedha za Safari ya Tamasha la Vijana',
                'description' => 'Tunapanga tamasha la vijana tarehe 15 mwezi ujao. Tunahitaji fedha za nauli, chakula na shughuli mbalimbali kwa vijana 120.',
                'department' => 'Vijana',
                'amount_requested' => 800000,
                'amount_approved' => null,
                'status' => 'Imekataliwa',
                'approval_notes' => 'Ombi limekataliwa na Mhasibu. Bajeti ya shughuli hii imeisha.',
                'requested_date' => Carbon::now()->subDays(10)->format('Y-m-d'),
                'approved_date' => null,
                'requested_by' => $mhasibuId,
                'approved_by' => null,
                'current_level' => 1,
                'max_level' => 2,
                'created_at' => Carbon::now()->subDays(10),
                'updated_at' => Carbon::now()->subDays(8),
            ],

            // ── APPROVED with signatures (high-value) ──
            [
                'request_number' => 'REQ2025003',
                'title' => 'Kanzu za Kwaya ya Vijana',
                'description' => 'Kwaya ya vijana ina wanachama 30 lakini kanzu ni 15 tu. Tunahitaji kanzu 15 zaidi.',
                'department' => 'Kwaya ya Vijana',
                'amount_requested' => 450000,
                'amount_approved' => 450000,
                'status' => 'Imeidhinishwa',
                'approval_notes' => 'Ombi limeidhinishwa kikamilifu. Hakikisheni ubora wa kanzu ni mzuri.',
                'requested_date' => Carbon::now()->subMonths(2)->format('Y-m-d'),
                'approved_date' => Carbon::now()->subMonths(2)->addDays(2)->format('Y-m-d'),
                'requested_by' => $mhasibuId,
                'approved_by' => $mchungajiId,
                'current_level' => 2,
                'max_level' => 2,
                'created_at' => Carbon::now()->subMonths(2),
                'updated_at' => Carbon::now()->subMonths(2)->addDays(2),
            ],
            [
                'request_number' => 'REQ2025004',
                'title' => 'Kompyuta kwa Ofisi ya Kanisa',
                'description' => 'Kompyuta ya ofisi imeharibika kabisa. Tunahitaji kompyuta mpya pamoja na printer.',
                'department' => 'Ofisi ya Kanisa',
                'amount_requested' => 1200000,
                'amount_approved' => 1000000,
                'status' => 'Imeidhinishwa',
                'approval_notes' => 'Nununue kompyuta ya bei ya wastani ambayo itafanya kazi. Kiasi cha TZS 1,000,000 kimeidhinishwa.',
                'requested_date' => Carbon::now()->subMonths(5)->format('Y-m-d'),
                'approved_date' => Carbon::now()->subMonths(5)->addDays(7)->format('Y-m-d'),
                'requested_by' => $mhasibuId,
                'approved_by' => $mchungajiId,
                'current_level' => 2,
                'max_level' => 2,
                'created_at' => Carbon::now()->subMonths(5),
                'updated_at' => Carbon::now()->subMonths(5)->addDays(7),
            ],

            // ── PENDING at level 1 (no steps yet, just submitted) ──
            [
                'request_number' => 'REQ2025008',
                'title' => 'Vifaa vya Ulinzi (Kamera za CCTV)',
                'description' => 'Kwa usalama wa kanisa, tunahitaji kusakinisha kamera za CCTV 6 katika maeneo muhimu ya kanisa.',
                'department' => 'Usalama',
                'amount_requested' => 1500000,
                'amount_approved' => null,
                'status' => 'Inasubiri',
                'approval_notes' => null,
                'requested_date' => Carbon::now()->subDays(2)->format('Y-m-d'),
                'approved_date' => null,
                'requested_by' => $mhasibuId,
                'approved_by' => null,
                'current_level' => 0,
                'max_level' => 2,
                'created_at' => Carbon::now()->subDays(2),
                'updated_at' => Carbon::now()->subDays(2),
            ],
            [
                'request_number' => 'REQ2025009',
                'title' => 'Msaada wa Wanafunzi Maskini',
                'description' => 'Kuna wanafunzi 5 kutoka familia maskini wanaohitaji msaada wa ada za shule. Tunahitaji TZS 1,000,000 kuwasaidia.',
                'department' => 'Elimu',
                'amount_requested' => 1000000,
                'amount_approved' => null,
                'status' => 'Inasubiri',
                'approval_notes' => null,
                'requested_date' => Carbon::now()->subDays(7)->format('Y-m-d'),
                'approved_date' => null,
                'requested_by' => $mhasibuId,
                'approved_by' => null,
                'current_level' => 0,
                'max_level' => 2,
                'created_at' => Carbon::now()->subDays(7),
                'updated_at' => Carbon::now()->subDays(7),
            ],

            // ── REJECTED old-style ──
            [
                'request_number' => 'REQ2025010',
                'title' => 'Ununuzi wa Gari la Kanisa',
                'description' => 'Tunahitaji gari la kanisa kwa huduma mbalimbali za kanisa na kusafirisha wahudumu.',
                'department' => 'Usafiri',
                'amount_requested' => 15000000,
                'amount_approved' => null,
                'status' => 'Imekataliwa',
                'approval_notes' => 'Ombi limekataliwa kwa sasa kwa sababu fedha za kanisa hazitoshi. Tunaweza kulifikiria baadaye.',
                'requested_date' => Carbon::now()->subMonths(1)->format('Y-m-d'),
                'approved_date' => Carbon::now()->subMonths(1)->addDays(4)->format('Y-m-d'),
                'requested_by' => $mhasibuId,
                'approved_by' => $mchungajiId,
                'current_level' => 2,
                'max_level' => 2,
                'created_at' => Carbon::now()->subMonths(1),
                'updated_at' => Carbon::now()->subMonths(1)->addDays(4),
            ],
            [
                'request_number' => 'REQ2025011',
                'title' => 'Safari ya Nje ya Nchi - Kongamano',
                'description' => 'Kuomba ruhusa na fedha kwa viongozi 3 kwenda kongamano la kimataifa Kenya.',
                'department' => 'Viongozi',
                'amount_requested' => 3000000,
                'amount_approved' => null,
                'status' => 'Imekataliwa',
                'approval_notes' => 'Ombi limekataliwa. Kuna ziara nyingi za ndani zinazohitaji fedha. Safari ya nje inaweza kungojea.',
                'requested_date' => Carbon::now()->subMonths(2)->format('Y-m-d'),
                'approved_date' => Carbon::now()->subMonths(2)->addDays(10)->format('Y-m-d'),
                'requested_by' => $mhasibuId,
                'approved_by' => $mchungajiId,
                'current_level' => 2,
                'max_level' => 2,
                'created_at' => Carbon::now()->subMonths(2),
                'updated_at' => Carbon::now()->subMonths(2)->addDays(10),
            ],
        ];

        foreach ($requests as $data) {
            Request::create($data);
        }

        // ── Create approval steps with digital signatures ──

        // Helper: generate a fake canvas signature as base64 PNG data
        $makeSignature = function (string $name, string $color) {
            $width = 300;
            $height = 80;
            $img = imagecreatetruecolor($width, $height);
            $bg = imagecolorallocate($img, 255, 255, 255);
            $ink = imagecolorallocate($img, hexdec(substr($color, 1, 2)), hexdec(substr($color, 3, 2)), hexdec(substr($color, 5, 2)));
            imagefill($img, 0, 0, $bg);

            // Draw a wavy signature-like line
            imagesetthickness($img, 2);
            $points = [];
            for ($x = 20; $x < $width - 20; $x++) {
                $y = 40 + (int)(15 * sin($x / 20)) + (int)(8 * cos($x / 13));
                $points[] = ['x' => $x, 'y' => $y];
            }
            for ($i = 1; $i < count($points); $i++) {
                imageline($img, $points[$i-1]['x'], $points[$i-1]['y'], $points[$i]['x'], $points[$i]['y'], $ink);
            }
            // Add name
            imagestring($img, 5, 20, 60, $name, $ink);

            ob_start();
            imagepng($img);
            $data = ob_get_clean();
            imagedestroy($img);
            return 'data:image/png;base64,' . base64_encode($data);
        };

        // ── REQ2025001: Fully approved (2 levels) ──
        $req1 = Request::where('request_number', 'REQ2025001')->first();
        if ($req1) {
            $ts1 = Carbon::now()->subMonths(3)->addDay()->toDateTimeString();
            $ts2 = Carbon::now()->subMonths(3)->addDays(5)->toDateTimeString();

            $hash1 = ApprovalStep::generateSignatureHash($mhasibuId, $req1->id, 1, $ts1);
            $hash2 = ApprovalStep::generateSignatureHash($mchungajiId, $req1->id, 2, $ts2);

            // Save signature PNGs to storage
            $sigPath1 = 'signatures/request_' . $req1->id . '_level1.png';
            $sigPath2 = 'signatures/request_' . $req1->id . '_level2.png';
            \Storage::disk('public')->put($sigPath1, $this->generateSignaturePng('Grace N. Kimaro', '#360958'));
            \Storage::disk('public')->put($sigPath2, $this->generateSignaturePng('J. Mwakasege', '#d4a81c'));

            ApprovalStep::create([
                'request_id' => $req1->id,
                'level' => 1,
                'role_required' => 'Mhasibu',
                'approver_user_id' => $mhasibuId,
                'decision' => 'approved',
                'comments' => 'Nimekagua na kuthibitisha. Kiasi kinafaa.',
                'digital_signature_hash' => $hash1,
                'signature_path' => $sigPath1,
                'ip_address' => '192.168.1.101',
                'device_fingerprint' => 'Chrome/120 Windows',
                'otp_verified' => true,
                'acted_at' => $ts1,
                'created_at' => $ts1,
                'updated_at' => $ts1,
            ]);

            ApprovalStep::create([
                'request_id' => $req1->id,
                'level' => 2,
                'role_required' => 'Mchungaji',
                'approver_user_id' => $mchungajiId,
                'decision' => 'approved',
                'comments' => 'Ombi limeidhinishwa. Nunua mara moja.',
                'digital_signature_hash' => $hash2,
                'signature_path' => $sigPath2,
                'ip_address' => '192.168.1.100',
                'device_fingerprint' => 'Chrome/120 macOS',
                'otp_verified' => true,
                'acted_at' => $ts2,
                'created_at' => $ts2,
                'updated_at' => $ts2,
            ]);
        }

        // ── REQ2025002: Fully approved (2 levels) ──
        $req2 = Request::where('request_number', 'REQ2025002')->first();
        if ($req2) {
            $ts1 = Carbon::now()->subMonths(4)->addDay()->toDateTimeString();
            $ts2 = Carbon::now()->subMonths(4)->addDays(3)->toDateTimeString();

            $hash1 = ApprovalStep::generateSignatureHash($mhasibuId, $req2->id, 1, $ts1);
            $hash2 = ApprovalStep::generateSignatureHash($mchungajiId, $req2->id, 2, $ts2);

            $sigPath1 = 'signatures/request_' . $req2->id . '_level1.png';
            $sigPath2 = 'signatures/request_' . $req2->id . '_level2.png';
            \Storage::disk('public')->put($sigPath1, $this->generateSignaturePng('Grace N. Kimaro', '#360958'));
            \Storage::disk('public')->put($sigPath2, $this->generateSignaturePng('J. Mwakasege', '#d4a81c'));

            ApprovalStep::create([
                'request_id' => $req2->id,
                'level' => 1,
                'role_required' => 'Mhasibu',
                'approver_user_id' => $mhasibuId,
                'decision' => 'approved',
                'comments' => 'Ukarabati ni muhimu. Nakubali.',
                'digital_signature_hash' => $hash1,
                'signature_path' => $sigPath1,
                'ip_address' => '192.168.1.101',
                'device_fingerprint' => 'Chrome/120 Windows',
                'otp_verified' => true,
                'acted_at' => $ts1,
                'created_at' => $ts1,
                'updated_at' => $ts1,
            ]);

            ApprovalStep::create([
                'request_id' => $req2->id,
                'level' => 2,
                'role_required' => 'Mchungaji',
                'approver_user_id' => $mchungajiId,
                'decision' => 'approved',
                'comments' => 'Idhini ya mwisho. Kamati ya ujenzi isimamie.',
                'digital_signature_hash' => $hash2,
                'signature_path' => $sigPath2,
                'ip_address' => '192.168.1.100',
                'device_fingerprint' => 'Chrome/120 macOS',
                'otp_verified' => true,
                'acted_at' => $ts2,
                'created_at' => $ts2,
                'updated_at' => $ts2,
            ]);
        }

        // ── REQ2025005: Pending at level 1 — Mhasibu approved, waiting for Mchungaji ──
        $req5 = Request::where('request_number', 'REQ2025005')->first();
        if ($req5) {
            $ts1 = Carbon::now()->subDays(3)->toDateTimeString();

            $hash1 = ApprovalStep::generateSignatureHash($mhasibuId, $req5->id, 1, $ts1);

            $sigPath1 = 'signatures/request_' . $req5->id . '_level1.png';
            \Storage::disk('public')->put($sigPath1, $this->generateSignaturePng('Grace N. Kimaro', '#360958'));

            // Level 1: Mhasibu approved
            ApprovalStep::create([
                'request_id' => $req5->id,
                'level' => 1,
                'role_required' => 'Mhasibu',
                'approver_user_id' => $mhasibuId,
                'decision' => 'approved',
                'comments' => 'Nimekagua. Msaada ni wa dharura, nakubali.',
                'digital_signature_hash' => $hash1,
                'signature_path' => $sigPath1,
                'ip_address' => '192.168.1.101',
                'device_fingerprint' => 'Chrome/120 Windows',
                'otp_verified' => true,
                'acted_at' => $ts1,
                'created_at' => $ts1,
                'updated_at' => $ts1,
            ]);

            // Level 2: Mchungaji — pending (no acted_at, no signature)
            ApprovalStep::create([
                'request_id' => $req5->id,
                'level' => 2,
                'role_required' => 'Mchungaji',
                'approver_user_id' => null,
                'decision' => null,
                'comments' => null,
                'digital_signature_hash' => null,
                'signature_path' => null,
                'ip_address' => null,
                'device_fingerprint' => null,
                'otp_verified' => false,
                'acted_at' => null,
                'created_at' => $ts1,
                'updated_at' => $ts1,
            ]);
        }

        // ── REQ2025006: Level 1 approved, Level 2 pending ──
        $req6 = Request::where('request_number', 'REQ2025006')->first();
        if ($req6) {
            $ts1 = Carbon::now()->subDays(2)->toDateTimeString();

            $hash1 = ApprovalStep::generateSignatureHash($mhasibuId, $req6->id, 1, $ts1);

            $sigPath1 = 'signatures/request_' . $req6->id . '_level1.png';
            \Storage::disk('public')->put($sigPath1, $this->generateSignaturePng('Grace N. Kimaro', '#360958'));

            ApprovalStep::create([
                'request_id' => $req6->id,
                'level' => 1,
                'role_required' => 'Mhasibu',
                'approver_user_id' => $mhasibuId,
                'decision' => 'approved',
                'comments' => 'Projector ni muhimu kwa elimu. Nakubali kiasi.',
                'digital_signature_hash' => $hash1,
                'signature_path' => $sigPath1,
                'ip_address' => '192.168.1.101',
                'device_fingerprint' => 'Safari/iOS',
                'otp_verified' => true,
                'acted_at' => $ts1,
                'created_at' => $ts1,
                'updated_at' => $ts1,
            ]);

            ApprovalStep::create([
                'request_id' => $req6->id,
                'level' => 2,
                'role_required' => 'Mchungaji',
                'approver_user_id' => null,
                'decision' => null,
                'comments' => null,
                'digital_signature_hash' => null,
                'signature_path' => null,
                'ip_address' => null,
                'device_fingerprint' => null,
                'otp_verified' => false,
                'acted_at' => null,
                'created_at' => $ts1,
                'updated_at' => $ts1,
            ]);
        }

        // ── REQ2025007: Rejected at level 1 ──
        $req7 = Request::where('request_number', 'REQ2025007')->first();
        if ($req7) {
            $ts1 = Carbon::now()->subDays(8)->toDateTimeString();

            $hash1 = ApprovalStep::generateSignatureHash($mhasibuId, $req7->id, 1, $ts1);

            $sigPath1 = 'signatures/request_' . $req7->id . '_level1.png';
            \Storage::disk('public')->put($sigPath1, $this->generateSignaturePng('Grace N. Kimaro', '#360958'));

            ApprovalStep::create([
                'request_id' => $req7->id,
                'level' => 1,
                'role_required' => 'Mhasibu',
                'approver_user_id' => $mhasibuId,
                'decision' => 'rejected',
                'comments' => 'Bajeti ya shughuli hii imeisha kwa mwezi huu. Tafadhali omba mwezi ujao.',
                'digital_signature_hash' => $hash1,
                'signature_path' => $sigPath1,
                'ip_address' => '192.168.1.101',
                'device_fingerprint' => 'Chrome/120 Windows',
                'otp_verified' => true,
                'acted_at' => $ts1,
                'created_at' => $ts1,
                'updated_at' => $ts1,
            ]);

            // Level 2 never reached
            ApprovalStep::create([
                'request_id' => $req7->id,
                'level' => 2,
                'role_required' => 'Mchungaji',
                'approver_user_id' => null,
                'decision' => null,
                'comments' => null,
                'digital_signature_hash' => null,
                'signature_path' => null,
                'ip_address' => null,
                'device_fingerprint' => null,
                'otp_verified' => false,
                'acted_at' => null,
                'created_at' => $ts1,
                'updated_at' => $ts1,
            ]);
        }

        // ── REQ2025003: Fully approved ──
        $req3 = Request::where('request_number', 'REQ2025003')->first();
        if ($req3) {
            $ts1 = Carbon::now()->subMonths(2)->addDay()->toDateTimeString();
            $ts2 = Carbon::now()->subMonths(2)->addDays(2)->toDateTimeString();

            $hash1 = ApprovalStep::generateSignatureHash($mhasibuId, $req3->id, 1, $ts1);
            $hash2 = ApprovalStep::generateSignatureHash($mchungajiId, $req3->id, 2, $ts2);

            $sigPath1 = 'signatures/request_' . $req3->id . '_level1.png';
            $sigPath2 = 'signatures/request_' . $req3->id . '_level2.png';
            \Storage::disk('public')->put($sigPath1, $this->generateSignaturePng('Grace N. Kimaro', '#360958'));
            \Storage::disk('public')->put($sigPath2, $this->generateSignaturePng('J. Mwakasege', '#d4a81c'));

            ApprovalStep::create([
                'request_id' => $req3->id,
                'level' => 1,
                'role_required' => 'Mhasibu',
                'approver_user_id' => $mhasibuId,
                'decision' => 'approved',
                'comments' => 'Bei ni nzuri. Nakubali.',
                'digital_signature_hash' => $hash1,
                'signature_path' => $sigPath1,
                'ip_address' => '192.168.1.101',
                'device_fingerprint' => 'Chrome/120 Windows',
                'otp_verified' => true,
                'acted_at' => $ts1,
                'created_at' => $ts1,
                'updated_at' => $ts1,
            ]);

            ApprovalStep::create([
                'request_id' => $req3->id,
                'level' => 2,
                'role_required' => 'Mchungaji',
                'approver_user_id' => $mchungajiId,
                'decision' => 'approved',
                'comments' => 'Nimeidhinisha. Kanzu nzuri kwa vijana.',
                'digital_signature_hash' => $hash2,
                'signature_path' => $sigPath2,
                'ip_address' => '192.168.1.100',
                'device_fingerprint' => 'Chrome/120 macOS',
                'otp_verified' => true,
                'acted_at' => $ts2,
                'created_at' => $ts2,
                'updated_at' => $ts2,
            ]);
        }

        // ── REQ2025004: Fully approved ──
        $req4 = Request::where('request_number', 'REQ2025004')->first();
        if ($req4) {
            $ts1 = Carbon::now()->subMonths(5)->addDays(2)->toDateTimeString();
            $ts2 = Carbon::now()->subMonths(5)->addDays(7)->toDateTimeString();

            $hash1 = ApprovalStep::generateSignatureHash($mhasibuId, $req4->id, 1, $ts1);
            $hash2 = ApprovalStep::generateSignatureHash($mchungajiId, $req4->id, 2, $ts2);

            $sigPath1 = 'signatures/request_' . $req4->id . '_level1.png';
            $sigPath2 = 'signatures/request_' . $req4->id . '_level2.png';
            \Storage::disk('public')->put($sigPath1, $this->generateSignaturePng('Grace N. Kimaro', '#360958'));
            \Storage::disk('public')->put($sigPath2, $this->generateSignaturePng('J. Mwakasege', '#d4a81c'));

            ApprovalStep::create([
                'request_id' => $req4->id,
                'level' => 1,
                'role_required' => 'Mhasibu',
                'approver_user_id' => $mhasibuId,
                'decision' => 'approved',
                'comments' => 'Kompyuta ni muhimu kwa ofisi. Bei ya TZS 1,000,000 inafaa.',
                'digital_signature_hash' => $hash1,
                'signature_path' => $sigPath1,
                'ip_address' => '192.168.1.101',
                'device_fingerprint' => 'Chrome/120 Windows',
                'otp_verified' => true,
                'acted_at' => $ts1,
                'created_at' => $ts1,
                'updated_at' => $ts1,
            ]);

            ApprovalStep::create([
                'request_id' => $req4->id,
                'level' => 2,
                'role_required' => 'Mchungaji',
                'approver_user_id' => $mchungajiId,
                'decision' => 'approved',
                'comments' => 'Idhini ya mwisho. Nunua haraka iwezekanavyo.',
                'digital_signature_hash' => $hash2,
                'signature_path' => $sigPath2,
                'ip_address' => '192.168.1.100',
                'device_fingerprint' => 'Chrome/120 macOS',
                'otp_verified' => true,
                'acted_at' => $ts2,
                'created_at' => $ts2,
                'updated_at' => $ts2,
            ]);
        }

        // ── REQ2025010: Fully approved (rejected later) ──
        $req10 = Request::where('request_number', 'REQ2025010')->first();
        if ($req10) {
            $ts1 = Carbon::now()->subMonths(1)->addDay()->toDateTimeString();
            $ts2 = Carbon::now()->subMonths(1)->addDays(4)->toDateTimeString();

            $hash1 = ApprovalStep::generateSignatureHash($mhasibuId, $req10->id, 1, $ts1);
            $hash2 = ApprovalStep::generateSignatureHash($mchungajiId, $req10->id, 2, $ts2);

            $sigPath1 = 'signatures/request_' . $req10->id . '_level1.png';
            $sigPath2 = 'signatures/request_' . $req10->id . '_level2.png';
            \Storage::disk('public')->put($sigPath1, $this->generateSignaturePng('Grace N. Kimaro', '#360958'));
            \Storage::disk('public')->put($sigPath2, $this->generateSignaturePng('J. Mwakasege', '#d4a81c'));

            ApprovalStep::create([
                'request_id' => $req10->id,
                'level' => 1,
                'role_required' => 'Mhasibu',
                'approver_user_id' => $mhasibuId,
                'decision' => 'approved',
                'comments' => 'Nimekagua ombi. Kiasi kubwa lakini linafaa.',
                'digital_signature_hash' => $hash1,
                'signature_path' => $sigPath1,
                'ip_address' => '192.168.1.101',
                'device_fingerprint' => 'Chrome/120 Windows',
                'otp_verified' => true,
                'acted_at' => $ts1,
                'created_at' => $ts1,
                'updated_at' => $ts1,
            ]);

            ApprovalStep::create([
                'request_id' => $req10->id,
                'level' => 2,
                'role_required' => 'Mchungaji',
                'approver_user_id' => $mchungajiId,
                'decision' => 'rejected',
                'comments' => 'Fedha hazitoshi kwa sasa. Tafadhali subiri.',
                'digital_signature_hash' => $hash2,
                'signature_path' => $sigPath2,
                'ip_address' => '192.168.1.100',
                'device_fingerprint' => 'Chrome/120 macOS',
                'otp_verified' => true,
                'acted_at' => $ts2,
                'created_at' => $ts2,
                'updated_at' => $ts2,
            ]);
        }

        // ── REQ2025011: Fully approved (rejected at level 2) ──
        $req11 = Request::where('request_number', 'REQ2025011')->first();
        if ($req11) {
            $ts1 = Carbon::now()->subMonths(2)->addDays(3)->toDateTimeString();
            $ts2 = Carbon::now()->subMonths(2)->addDays(10)->toDateTimeString();

            $hash1 = ApprovalStep::generateSignatureHash($mhasibuId, $req11->id, 1, $ts1);
            $hash2 = ApprovalStep::generateSignatureHash($mchungajiId, $req11->id, 2, $ts2);

            $sigPath1 = 'signatures/request_' . $req11->id . '_level1.png';
            $sigPath2 = 'signatures/request_' . $req11->id . '_level2.png';
            \Storage::disk('public')->put($sigPath1, $this->generateSignaturePng('Grace N. Kimaro', '#360958'));
            \Storage::disk('public')->put($sigPath2, $this->generateSignaturePng('J. Mwakasege', '#d4a81c'));

            ApprovalStep::create([
                'request_id' => $req11->id,
                'level' => 1,
                'role_required' => 'Mhasibu',
                'approver_user_id' => $mhasibuId,
                'decision' => 'approved',
                'comments' => 'Ombi ni la kijamii. Nakubali.',
                'digital_signature_hash' => $hash1,
                'signature_path' => $sigPath1,
                'ip_address' => '192.168.1.101',
                'device_fingerprint' => 'Chrome/120 Windows',
                'otp_verified' => true,
                'acted_at' => $ts1,
                'created_at' => $ts1,
                'updated_at' => $ts1,
            ]);

            ApprovalStep::create([
                'request_id' => $req11->id,
                'level' => 2,
                'role_required' => 'Mchungaji',
                'approver_user_id' => $mchungajiId,
                'decision' => 'rejected',
                'comments' => 'Safari ya nje ni ghali. Kuna safari ndani zinazohitaji kwanza.',
                'digital_signature_hash' => $hash2,
                'signature_path' => $sigPath2,
                'ip_address' => '192.168.1.100',
                'device_fingerprint' => 'Chrome/120 macOS',
                'otp_verified' => true,
                'acted_at' => $ts2,
                'created_at' => $ts2,
                'updated_at' => $ts2,
            ]);
        }

        $stepCount = ApprovalStep::count();
        $this->command->info("✓ " . count($requests) . " maombi na " . $stepCount . " approval steps yameongezwa!");
    }

    /**
     * Generate a simple signature PNG as a string (no external deps).
     */
    private function generateSignaturePng(string $name, string $color): string
    {
        $width = 300;
        $height = 80;
        $img = imagecreatetruecolor($width, $height);
        $bg = imagecolorallocate($img, 255, 255, 255);
        $ink = imagecolorallocate(
            $img,
            hexdec(substr($color, 1, 2)),
            hexdec(substr($color, 3, 2)),
            hexdec(substr($color, 5, 2))
        );
        imagefill($img, 0, 0, $bg);

        // Draw signature line
        imagesetthickness($img, 2);
        for ($x = 20; $x < $width - 30; $x++) {
            $y1 = 40 + (int)(15 * sin($x / 18)) + (int)(8 * cos($x / 11));
            $y2 = 40 + (int)(15 * sin(($x + 1) / 18)) + (int)(8 * cos(($x + 1) / 11));
            imageline($img, $x, $y1, $x + 1, $y2, $ink);
        }

        // Add name below
        imagestring($img, 5, 20, 58, $name, $ink);

        ob_start();
        imagepng($img);
        $data = ob_get_clean();
        imagedestroy($img);
        return $data;
    }
}
