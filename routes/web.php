<?php

use Illuminate\Support\Facades\Route;

$factors = [
    1 => [
        'number' => '01',
        'name' => 'Governed Operations',
        'principle' => 'No enterprise concern delegates to an agentic protocol.',
        'description' => 'Protocols like MCP are thin by design — purpose-built for specific things in the reasoning layer. They don\'t take care of enterprise concerns. Authentication, audit trails, compliance controls, access policies — none of that belongs inside the protocol layer. You have to take care of it yourself. Don\'t wait for the standard to adopt what your business needs right now.',
        'detail' => 'The core of this principle is simple but hard in execution: the protocols themselves (MCP, Skills.md, Agents.md) are purpose-built for specific things in the reasoning layer, but they aren\'t taking care of all the enterprise concerns. There will always be more stuff around the protocol that the business cares about — and in some cases, those concerns are unique to your company.',
        'example' => 'If you\'re in a regulated industry, the dial goes up further. Authentication, audit trails, compliance controls — none of that belongs inside the protocol layer. You own it.',
        'rule' => 'Don\'t try to put enterprise concerns in a place where they don\'t belong. Don\'t force authentication into MCP because it wasn\'t designed to handle it. Take care of it yourself — in your control plane.',
        'related' => [2, 4, 7],
    ],
    2 => [
        'number' => '02',
        'name' => 'Deterministic Mutations',
        'principle' => 'All state mutations belong to the control plane.',
        'description' => 'The control plane should own all creates, writes, and deletes. Never allow the probabilistic reasoning layer to have direct write access to state it could destroy. The deterministic layer controls mutations to data your business cares about — and provides the guarantees that business-critical operations require.',
        'detail' => 'When a clinician needs the right prescription, or a customer needs exactly one charge, those guarantees belong in the control plane. A probabilistic layer making direct mutations to business-critical state is an architectural failure waiting to happen.',
        'example' => 'A clinician needs the right prescription. A customer needs exactly one charge. These guarantees belong in the control plane — not in the LLM.',
        'rule' => 'The reasoning layer proposes. The control plane disposes. No direct write access from probabilistic callers to business-critical state.',
        'related' => [1, 5, 6],
    ],
    3 => [
        'number' => '03',
        'name' => 'Intent-Based Communication',
        'principle' => 'Tool boundaries follow intent, not implementation.',
        'description' => 'How probabilistic callers communicate with the control plane should be about the tool\'s intent — not leaking details about the underlying implementation. Don\'t flood the LLM context with a sequence of raw API calls. Start with the intent, work backwards. Abstract the implementation away from the reasoning layer.',
        'detail' => 'This matters for two reasons: it leaves more context for the reasoning layer to have richer interactions, and it minimizes the exfiltration surface area by hiding what system is actually being called and how. The reasoning layer shouldn\'t know whether it\'s talking to one system or seventeen underlying APIs.',
        'example' => 'Instead of exposing the sequence of API calls needed to complete a mutation, expose a single intent-based tool: "schedule_appointment" rather than "GET /availability, POST /booking, PUT /confirmation."',
        'rule' => 'Design tools outside-in. Start with the intent, then decide what implementation sits behind it. Never design tools that mirror your internal API surface.',
        'related' => [1, 4, 7],
    ],
    4 => [
        'number' => '04',
        'name' => 'Bounded Access',
        'principle' => 'Each caller sees only the capabilities its role requires.',
        'description' => 'Least privilege isn\'t new — but the patterns look fundamentally different in the agentic era. When callers are probabilistic and behaviors are non-deterministic, gateway-level filtering and per-role tool restrictions become critical. The blast radius of a compromised or misbehaving agent must be bounded by architecture, not by hope.',
        'detail' => 'If a prompt-injected agent encounters the lethal trifecta — a malicious prompt, write access, and no bounded scope — the damage is unbounded. Bounded access is what limits that radius. This is least privilege reimagined for systems where you can\'t fully trust the caller.',
        'example' => 'A customer service agent should see customer data tools. It should not see billing mutation tools. A reporting agent should see read operations. It should not see write operations.',
        'rule' => 'Design access controls at the gateway level, not just at the tool level. Every agent role gets a scope. No agent role gets more than its role requires.',
        'related' => [1, 3, 5],
    ],
    5 => [
        'number' => '05',
        'name' => 'Safe Retries',
        'principle' => 'Every mutation is safely retried by a probabilistic caller.',
        'description' => 'When your caller is probabilistic, it doesn\'t know whether it\'s calling for the first time or the second. Your idempotency keys break. Your deduplication layers stop working correctly. You have to build for different retry patterns than you\'re used to — because the assumptions baked into your existing systems no longer hold.',
        'detail' => 'Traditional idempotency assumes the caller can send genuinely identical requests with the same key. A probabilistic caller may construct the "same" request in subtly different ways each time — different phrasing, different parameter ordering, different inferred values. Your dedup logic was designed for deterministic callers. It\'s now talking to something that isn\'t.',
        'example' => 'A probabilistic caller retrying a payment mutation may phrase the request differently each time. Without safe retry infrastructure in the control plane, you risk double-charges or silently dropped operations.',
        'rule' => 'Build retry safety into the control plane, not into the reasoning layer. The reasoning layer shouldn\'t be responsible for knowing whether a mutation already succeeded.',
        'related' => [2, 6, 7],
    ],
    6 => [
        'number' => '06',
        'name' => 'Recovery Contracts',
        'principle' => 'The reasoning layer never guesses at state.',
        'description' => 'If retries are different, errors are different too. Logic can\'t always branch deterministically on a 400 vs. a 500 when the caller is probabilistic. The control plane needs to give the reasoning layer a message about whether it\'s safe to retry — not just a static error code to be interpreted by something that may interpret it wrong.',
        'detail' => 'A reasoning caller receiving a raw 500 doesn\'t know what happened or what to do next. Did the mutation succeed before the error? Is it safe to try again? A recovery contract answers those questions explicitly — removing the guesswork and the potential for a probabilistic caller to make a bad decision about whether to proceed.',
        'example' => '"safe_to_retry: true, state: unchanged" vs. "safe_to_retry: false, state: partially_committed" — the reasoning layer needs a message, not a status code.',
        'rule' => 'Every error response from the control plane is a contract, not just a code. Include state information and retry guidance. Remove the need for the reasoning layer to guess.',
        'related' => [2, 5, 7],
    ],
    7 => [
        'number' => '07',
        'name' => 'Structural Observability',
        'principle' => 'Every agent action is reconstructable by architecture.',
        'description' => 'LLMs are black boxes. Even if you ask one what it did, you\'re not guaranteed to get a truthful answer. Observability has to be enforced outside the LLM — in the deterministic control layer, by design, not because a developer decided to capture a log. If you\'re already letting the control plane own mutations and retries, much of this comes for free.',
        'detail' => 'What happened? What was the intent? What system called and why? These questions need answers the architecture guarantees — not answers the LLM volunteers. Observability by design means the control plane captures intent, caller identity, and outcome as a structural property of every operation, not as an afterthought.',
        'example' => 'When an autonomous agent takes an unexpected action at 2am, "I asked the LLM what it did and it said..." is not an acceptable audit trail. The control plane should have the answer independently.',
        'rule' => 'Treat observability as a correctness property, not a debugging tool. The control plane should make every action reconstructable without asking the reasoning layer what happened.',
        'related' => [1, 3, 6],
    ],
];

Route::get('/', function () {
    return view('landing');
});

Route::get('/campaign', function () {
    return view('campaign');
});

Route::get('/factor/{number}', function (int $number) use ($factors) {
    if (!isset($factors[$number])) {
        abort(404);
    }
    return view('factor', [
        'factor' => $factors[$number],
        'number' => $number,
        'allFactors' => $factors,
    ]);
})->where('number', '[1-7]');
