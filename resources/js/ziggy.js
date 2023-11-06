const Ziggy = {
    "url": "http:\/\/new-locked-up.test:8080", "port": 8080, "defaults": {}, "routes": {
        "sanctum.csrf-cookie": {"uri": "sanctum\/csrf-cookie", "methods": ["GET", "HEAD"]},
        "ignition.healthCheck": {"uri": "_ignition\/health-check", "methods": ["GET", "HEAD"]},
        "ignition.executeSolution": {"uri": "_ignition\/execute-solution", "methods": ["POST"]},
        "ignition.updateConfig": {"uri": "_ignition\/update-config", "methods": ["POST"]},
        "bookings.index": {"uri": "bookings", "methods": ["GET", "HEAD"]},
        "bookings.create": {"uri": "bookings\/create", "methods": ["GET", "HEAD"]},
        "bookings.store": {"uri": "bookings", "methods": ["POST"]},
        "bookings.show": {"uri": "bookings\/{booking}", "methods": ["GET", "HEAD"]},
        "bookings.edit": {"uri": "bookings\/{booking}\/edit", "methods": ["GET", "HEAD"]},
        "bookings.update": {"uri": "bookings\/{booking}", "methods": ["PUT", "PATCH"]},
        "bookings.destroy": {"uri": "bookings\/{booking}", "methods": ["DELETE"]},
        "bookings.make": {"uri": "bookings\/{scheduleId}\/make", "methods": ["PATCH"]},
        "bookings.undo": {"uri": "bookings\/{scheduleId}\/undo", "methods": ["PATCH"]},
        "bookings.make_many": {"uri": "bookings\/make_many", "methods": ["POST"]},
        "bookings.undo_many": {"uri": "bookings\/undo_many", "methods": ["POST"]},
        "orders.index": {"uri": "orders", "methods": ["GET", "HEAD"]},
        "orders.create": {"uri": "orders\/create", "methods": ["GET", "HEAD"]},
        "orders.store": {"uri": "orders", "methods": ["POST"]},
        "orders.show": {"uri": "orders\/{order}", "methods": ["GET", "HEAD"], "bindings": {"order": "id"}},
        "orders.edit": {"uri": "orders\/{order}\/edit", "methods": ["GET", "HEAD"]},
        "orders.update": {"uri": "orders\/{order}", "methods": ["PUT", "PATCH"], "bindings": {"order": "id"}},
        "orders.destroy": {"uri": "orders\/{order}", "methods": ["DELETE"]},
        "appeals.index": {"uri": "appeals", "methods": ["GET", "HEAD"]},
        "appeals.create": {"uri": "appeals\/create", "methods": ["GET", "HEAD"]},
        "appeals.store": {"uri": "appeals", "methods": ["POST"]},
        "appeals.show": {"uri": "appeals\/{appeal}", "methods": ["GET", "HEAD"], "bindings": {"appeal": "id"}},
        "appeals.edit": {"uri": "appeals\/{appeal}\/edit", "methods": ["GET", "HEAD"]},
        "appeals.update": {"uri": "appeals\/{appeal}", "methods": ["PUT", "PATCH"], "bindings": {"appeal": "id"}},
        "appeals.destroy": {"uri": "appeals\/{appeal}", "methods": ["DELETE"]},
        "certificates.index": {"uri": "certificates", "methods": ["GET", "HEAD"]},
        "certificates.create": {"uri": "certificates\/create", "methods": ["GET", "HEAD"]},
        "certificates.store": {"uri": "certificates", "methods": ["POST"]},
        "certificates.show": {
            "uri": "certificates\/{certificate}",
            "methods": ["GET", "HEAD"],
            "bindings": {"certificate": "id"}
        },
        "certificates.edit": {"uri": "certificates\/{certificate}\/edit", "methods": ["GET", "HEAD"]},
        "certificates.update": {
            "uri": "certificates\/{certificate}",
            "methods": ["PUT", "PATCH"],
            "bindings": {"certificate": "id"}
        },
        "certificates.destroy": {"uri": "certificates\/{certificate}", "methods": ["DELETE"]},
        "order-filters.index": {"uri": "order-filters", "methods": ["GET", "HEAD"]},
        "order-filters.create": {"uri": "order-filters\/create", "methods": ["GET", "HEAD"]},
        "order-filters.store": {"uri": "order-filters", "methods": ["POST"]},
        "order-filters.show": {"uri": "order-filters\/{order_filter}", "methods": ["GET", "HEAD"]},
        "order-filters.edit": {"uri": "order-filters\/{order_filter}\/edit", "methods": ["GET", "HEAD"]},
        "order-filters.update": {"uri": "order-filters\/{order_filter}", "methods": ["PUT", "PATCH"]},
        "order-filters.destroy": {"uri": "order-filters\/{order_filter}", "methods": ["DELETE"]},
        "orders.destroy-many": {"uri": "orders\/delete_many", "methods": ["POST"]},
        "appeals.destroy-many": {"uri": "appeals\/delete_many", "methods": ["POST"]},
        "certificates.destroy-many": {"uri": "certificates\/delete_many", "methods": ["POST"]},
        "order-filters.destroy-many": {"uri": "order-filters\/delete_many", "methods": ["POST"]},
        "quests.index": {"uri": "quests", "methods": ["GET", "HEAD"]},
        "quests.create": {"uri": "quests\/create", "methods": ["GET", "HEAD"]},
        "quests.store": {"uri": "quests", "methods": ["POST"]},
        "quests.show": {"uri": "quests\/{quest}", "methods": ["GET", "HEAD"], "bindings": {"quest": "id"}},
        "quests.edit": {"uri": "quests\/{quest}\/edit", "methods": ["GET", "HEAD"]},
        "quests.update": {"uri": "quests\/{quest}", "methods": ["PUT", "PATCH"], "bindings": {"quest": "id"}},
        "quests.destroy": {"uri": "quests\/{quest}", "methods": ["DELETE"]},
        "performance-quests.index": {"uri": "performance-quests", "methods": ["GET", "HEAD"]},
        "performance-quests.create": {"uri": "performance-quests\/create", "methods": ["GET", "HEAD"]},
        "performance-quests.store": {"uri": "performance-quests", "methods": ["POST"]},
        "performance-quests.show": {"uri": "performance-quests\/{performance_quest}", "methods": ["GET", "HEAD"]},
        "performance-quests.edit": {"uri": "performance-quests\/{performance_quest}\/edit", "methods": ["GET", "HEAD"]},
        "performance-quests.update": {"uri": "performance-quests\/{performance_quest}", "methods": ["PUT", "PATCH"]},
        "performance-quests.destroy": {"uri": "performance-quests\/{performance_quest}", "methods": ["DELETE"]},
        "locations.index": {"uri": "locations", "methods": ["GET", "HEAD"]},
        "locations.create": {"uri": "locations\/create", "methods": ["GET", "HEAD"]},
        "locations.store": {"uri": "locations", "methods": ["POST"]},
        "locations.show": {"uri": "locations\/{location}", "methods": ["GET", "HEAD"], "bindings": {"location": "id"}},
        "locations.edit": {"uri": "locations\/{location}\/edit", "methods": ["GET", "HEAD"]},
        "locations.update": {
            "uri": "locations\/{location}",
            "methods": ["PUT", "PATCH"],
            "bindings": {"location": "id"}
        },
        "locations.destroy": {"uri": "locations\/{location}", "methods": ["DELETE"]},
        "services.index": {"uri": "services", "methods": ["GET", "HEAD"]},
        "services.create": {"uri": "services\/create", "methods": ["GET", "HEAD"]},
        "services.store": {"uri": "services", "methods": ["POST"]},
        "services.show": {"uri": "services\/{service}", "methods": ["GET", "HEAD"]},
        "services.edit": {"uri": "services\/{service}\/edit", "methods": ["GET", "HEAD"]},
        "services.update": {"uri": "services\/{service}", "methods": ["PUT", "PATCH"]},
        "services.destroy": {"uri": "services\/{service}", "methods": ["DELETE"]},
        "schedules.index": {"uri": "schedules", "methods": ["GET", "HEAD"]},
        "schedules.create": {"uri": "schedules\/create", "methods": ["GET", "HEAD"]},
        "schedules.store": {"uri": "schedules", "methods": ["POST"]},
        "schedules.show": {"uri": "schedules\/{schedule}", "methods": ["GET", "HEAD"], "bindings": {"schedule": "id"}},
        "schedules.edit": {"uri": "schedules\/{schedule}\/edit", "methods": ["GET", "HEAD"]},
        "schedules.update": {
            "uri": "schedules\/{schedule}",
            "methods": ["PUT", "PATCH"],
            "bindings": {"schedule": "id"}
        },
        "schedules.destroy": {"uri": "schedules\/{schedule}", "methods": ["DELETE"]},
        "quest-topics.index": {"uri": "quest-topics", "methods": ["GET", "HEAD"]},
        "quest-topics.create": {"uri": "quest-topics\/create", "methods": ["GET", "HEAD"]},
        "quest-topics.store": {"uri": "quest-topics", "methods": ["POST"]},
        "quest-topics.show": {"uri": "quest-topics\/{quest_topic}", "methods": ["GET", "HEAD"]},
        "quest-topics.edit": {"uri": "quest-topics\/{quest_topic}\/edit", "methods": ["GET", "HEAD"]},
        "quest-topics.update": {"uri": "quest-topics\/{quest_topic}", "methods": ["PUT", "PATCH"]},
        "quest-topics.destroy": {"uri": "quest-topics\/{quest_topic}", "methods": ["DELETE"]},
        "child-quest-topics.index": {"uri": "child-quest-topics", "methods": ["GET", "HEAD"]},
        "child-quest-topics.create": {"uri": "child-quest-topics\/create", "methods": ["GET", "HEAD"]},
        "child-quest-topics.store": {"uri": "child-quest-topics", "methods": ["POST"]},
        "child-quest-topics.show": {"uri": "child-quest-topics\/{child_quest_topic}", "methods": ["GET", "HEAD"]},
        "child-quest-topics.edit": {"uri": "child-quest-topics\/{child_quest_topic}\/edit", "methods": ["GET", "HEAD"]},
        "child-quest-topics.update": {"uri": "child-quest-topics\/{child_quest_topic}", "methods": ["PUT", "PATCH"]},
        "child-quest-topics.destroy": {"uri": "child-quest-topics\/{child_quest_topic}", "methods": ["DELETE"]},
        "certificate-instances.index": {"uri": "certificate-instances", "methods": ["GET", "HEAD"]},
        "certificate-instances.create": {"uri": "certificate-instances\/create", "methods": ["GET", "HEAD"]},
        "certificate-instances.store": {"uri": "certificate-instances", "methods": ["POST"]},
        "certificate-instances.show": {
            "uri": "certificate-instances\/{certificate_instance}",
            "methods": ["GET", "HEAD"]
        },
        "certificate-instances.edit": {
            "uri": "certificate-instances\/{certificate_instance}\/edit",
            "methods": ["GET", "HEAD"]
        },
        "certificate-instances.update": {
            "uri": "certificate-instances\/{certificate_instance}",
            "methods": ["PUT", "PATCH"]
        },
        "certificate-instances.destroy": {
            "uri": "certificate-instances\/{certificate_instance}",
            "methods": ["DELETE"]
        },
        "sales.index": {"uri": "sales", "methods": ["GET", "HEAD"]},
        "sales.create": {"uri": "sales\/create", "methods": ["GET", "HEAD"]},
        "sales.store": {"uri": "sales", "methods": ["POST"]},
        "sales.show": {"uri": "sales\/{sale}", "methods": ["GET", "HEAD"], "bindings": {"sale": "id"}},
        "sales.edit": {"uri": "sales\/{sale}\/edit", "methods": ["GET", "HEAD"]},
        "sales.update": {"uri": "sales\/{sale}", "methods": ["PUT", "PATCH"], "bindings": {"sale": "id"}},
        "sales.destroy": {"uri": "sales\/{sale}", "methods": ["DELETE"]},
        "reviews.index": {"uri": "reviews", "methods": ["GET", "HEAD"]},
        "reviews.create": {"uri": "reviews\/create", "methods": ["GET", "HEAD"]},
        "reviews.store": {"uri": "reviews", "methods": ["POST"]},
        "reviews.show": {"uri": "reviews\/{review}", "methods": ["GET", "HEAD"], "bindings": {"review": "id"}},
        "reviews.edit": {"uri": "reviews\/{review}\/edit", "methods": ["GET", "HEAD"]},
        "reviews.update": {"uri": "reviews\/{review}", "methods": ["PUT", "PATCH"], "bindings": {"review": "id"}},
        "reviews.destroy": {"uri": "reviews\/{review}", "methods": ["DELETE"]},
        "order-sources.index": {"uri": "order-sources", "methods": ["GET", "HEAD"]},
        "order-sources.create": {"uri": "order-sources\/create", "methods": ["GET", "HEAD"]},
        "order-sources.store": {"uri": "order-sources", "methods": ["POST"]},
        "order-sources.show": {"uri": "order-sources\/{order_source}", "methods": ["GET", "HEAD"]},
        "order-sources.edit": {"uri": "order-sources\/{order_source}\/edit", "methods": ["GET", "HEAD"]},
        "order-sources.update": {"uri": "order-sources\/{order_source}", "methods": ["PUT", "PATCH"]},
        "order-sources.destroy": {"uri": "order-sources\/{order_source}", "methods": ["DELETE"]},
        "lounges.index": {"uri": "lounges", "methods": ["GET", "HEAD"]},
        "lounges.create": {"uri": "lounges\/create", "methods": ["GET", "HEAD"]},
        "lounges.store": {"uri": "lounges", "methods": ["POST"]},
        "lounges.show": {"uri": "lounges\/{lounge}", "methods": ["GET", "HEAD"], "bindings": {"lounge": "id"}},
        "lounges.edit": {"uri": "lounges\/{lounge}\/edit", "methods": ["GET", "HEAD"]},
        "lounges.update": {"uri": "lounges\/{lounge}", "methods": ["PUT", "PATCH"], "bindings": {"lounge": "id"}},
        "lounges.destroy": {"uri": "lounges\/{lounge}", "methods": ["DELETE"]},
        "lounge-schedules.index": {"uri": "lounge-schedules", "methods": ["GET", "HEAD"]},
        "lounge-schedules.create": {"uri": "lounge-schedules\/create", "methods": ["GET", "HEAD"]},
        "lounge-schedules.store": {"uri": "lounge-schedules", "methods": ["POST"]},
        "lounge-schedules.show": {"uri": "lounge-schedules\/{lounge_schedule}", "methods": ["GET", "HEAD"]},
        "lounge-schedules.edit": {"uri": "lounge-schedules\/{lounge_schedule}\/edit", "methods": ["GET", "HEAD"]},
        "lounge-schedules.update": {"uri": "lounge-schedules\/{lounge_schedule}", "methods": ["PUT", "PATCH"]},
        "lounge-schedules.destroy": {"uri": "lounge-schedules\/{lounge_schedule}", "methods": ["DELETE"]},
        "quests.destroy-many": {"uri": "quests\/delete_many", "methods": ["POST"]},
        "performance-quests.destroy-many": {"uri": "performance-quests\/delete_many", "methods": ["POST"]},
        "locations.destroy-many": {"uri": "locations\/delete_many", "methods": ["POST"]},
        "services.destroy-many": {"uri": "services\/delete_many", "methods": ["POST"]},
        "schedules.destroy-many": {"uri": "schedules\/delete_many", "methods": ["POST"]},
        "quest-topics.destroy-many": {"uri": "quest-topics\/delete_many", "methods": ["POST"]},
        "child-quest-topics.destroy-many": {"uri": "child-quest-topics\/delete_many", "methods": ["POST"]},
        "certificate-instances.destroy-many": {"uri": "certificate-instances\/delete_many", "methods": ["POST"]},
        "sales.destroy-many": {"uri": "sales\/delete_many", "methods": ["POST"]},
        "reviews.destroy-many": {"uri": "reviews\/delete_many", "methods": ["POST"]},
        "order-sources.destroy-many": {"uri": "order-sources\/delete_many", "methods": ["POST"]},
        "lounges.destroy-many": {"uri": "lounges\/delete_many", "methods": ["POST"]},
        "lounge-schedules.destroy-many": {"uri": "lounge-schedules\/delete_many", "methods": ["POST"]},
        "locations.location_lounges.index": {
            "uri": "locations\/{location}\/location_lounges",
            "methods": ["GET", "HEAD"]
        },
        "locations.location_lounges.create": {
            "uri": "locations\/{location}\/location_lounges\/create",
            "methods": ["GET", "HEAD"],
            "bindings": {"location": "id"}
        },
        "locations.location_lounges.store": {
            "uri": "locations\/{location}\/location_lounges",
            "methods": ["POST"],
            "bindings": {"location": "id"}
        },
        "locations.location_lounges.show": {
            "uri": "locations\/{location}\/location_lounges\/{location_lounge}",
            "methods": ["GET", "HEAD"],
            "bindings": {"location": "id"}
        },
        "locations.location_lounges.edit": {
            "uri": "locations\/{location}\/location_lounges\/{location_lounge}\/edit",
            "methods": ["GET", "HEAD"]
        },
        "locations.location_lounges.update": {
            "uri": "locations\/{location}\/location_lounges\/{location_lounge}",
            "methods": ["PUT", "PATCH"],
            "bindings": {"location": "id"}
        },
        "locations.location_lounges.destroy": {
            "uri": "locations\/{location}\/location_lounges\/{location_lounge}",
            "methods": ["DELETE"],
            "bindings": {"location": "id"}
        },
        "quests.quest_performance_shows.index": {
            "uri": "quests\/{quest}\/quest_performance_shows",
            "methods": ["GET", "HEAD"]
        },
        "quests.quest_performance_shows.create": {
            "uri": "quests\/{quest}\/quest_performance_shows\/create",
            "methods": ["GET", "HEAD"],
            "bindings": {"quest": "id"}
        },
        "quests.quest_performance_shows.store": {
            "uri": "quests\/{quest}\/quest_performance_shows",
            "methods": ["POST"],
            "bindings": {"quest": "id"}
        },
        "quests.quest_performance_shows.show": {
            "uri": "quests\/{quest}\/quest_performance_shows\/{quest_performance_show}",
            "methods": ["GET", "HEAD"],
            "bindings": {"quest": "id"}
        },
        "quests.quest_performance_shows.edit": {
            "uri": "quests\/{quest}\/quest_performance_shows\/{quest_performance_show}\/edit",
            "methods": ["GET", "HEAD"]
        },
        "quests.quest_performance_shows.update": {
            "uri": "quests\/{quest}\/quest_performance_shows\/{quest_performance_show}",
            "methods": ["PUT", "PATCH"],
            "bindings": {"quest": "id"}
        },
        "quests.quest_performance_shows.destroy": {
            "uri": "quests\/{quest}\/quest_performance_shows\/{quest_performance_show}",
            "methods": ["DELETE"],
            "bindings": {"quest": "id"}
        },
        "quests.quest_performance_loads.index": {
            "uri": "quests\/{quest}\/quest_performance_loads",
            "methods": ["GET", "HEAD"]
        },
        "quests.quest_performance_loads.create": {
            "uri": "quests\/{quest}\/quest_performance_loads\/create",
            "methods": ["GET", "HEAD"],
            "bindings": {"quest": "id"}
        },
        "quests.quest_performance_loads.store": {
            "uri": "quests\/{quest}\/quest_performance_loads",
            "methods": ["POST"],
            "bindings": {"quest": "id"}
        },
        "quests.quest_performance_loads.show": {
            "uri": "quests\/{quest}\/quest_performance_loads\/{quest_performance_load}",
            "methods": ["GET", "HEAD"],
            "bindings": {"quest": "id"}
        },
        "quests.quest_performance_loads.edit": {
            "uri": "quests\/{quest}\/quest_performance_loads\/{quest_performance_load}\/edit",
            "methods": ["GET", "HEAD"]
        },
        "quests.quest_performance_loads.update": {
            "uri": "quests\/{quest}\/quest_performance_loads\/{quest_performance_load}",
            "methods": ["PUT", "PATCH"],
            "bindings": {"quest": "id"}
        },
        "quests.quest_performance_loads.destroy": {
            "uri": "quests\/{quest}\/quest_performance_loads\/{quest_performance_load}",
            "methods": ["DELETE"],
            "bindings": {"quest": "id"}
        },
        "quests.quest_performance_experiments.index": {
            "uri": "quests\/{quest}\/quest_performance_experiments",
            "methods": ["GET", "HEAD"]
        },
        "quests.quest_performance_experiments.create": {
            "uri": "quests\/{quest}\/quest_performance_experiments\/create",
            "methods": ["GET", "HEAD"],
            "bindings": {"quest": "id"}
        },
        "quests.quest_performance_experiments.store": {
            "uri": "quests\/{quest}\/quest_performance_experiments",
            "methods": ["POST"],
            "bindings": {"quest": "id"}
        },
        "quests.quest_performance_experiments.show": {
            "uri": "quests\/{quest}\/quest_performance_experiments\/{quest_performance_experiment}",
            "methods": ["GET", "HEAD"],
            "bindings": {"quest": "id"}
        },
        "quests.quest_performance_experiments.edit": {
            "uri": "quests\/{quest}\/quest_performance_experiments\/{quest_performance_experiment}\/edit",
            "methods": ["GET", "HEAD"]
        },
        "quests.quest_performance_experiments.update": {
            "uri": "quests\/{quest}\/quest_performance_experiments\/{quest_performance_experiment}",
            "methods": ["PUT", "PATCH"],
            "bindings": {"quest": "id"}
        },
        "quests.quest_performance_experiments.destroy": {
            "uri": "quests\/{quest}\/quest_performance_experiments\/{quest_performance_experiment}",
            "methods": ["DELETE"],
            "bindings": {"quest": "id"}
        },
        "quests.quest_performance_lounges.index": {
            "uri": "quests\/{quest}\/quest_performance_lounges",
            "methods": ["GET", "HEAD"]
        },
        "quests.quest_performance_lounges.create": {
            "uri": "quests\/{quest}\/quest_performance_lounges\/create",
            "methods": ["GET", "HEAD"],
            "bindings": {"quest": "id"}
        },
        "quests.quest_performance_lounges.store": {
            "uri": "quests\/{quest}\/quest_performance_lounges",
            "methods": ["POST"],
            "bindings": {"quest": "id"}
        },
        "quests.quest_performance_lounges.show": {
            "uri": "quests\/{quest}\/quest_performance_lounges\/{quest_performance_lounge}",
            "methods": ["GET", "HEAD"],
            "bindings": {"quest": "id"}
        },
        "quests.quest_performance_lounges.edit": {
            "uri": "quests\/{quest}\/quest_performance_lounges\/{quest_performance_lounge}\/edit",
            "methods": ["GET", "HEAD"]
        },
        "quests.quest_performance_lounges.update": {
            "uri": "quests\/{quest}\/quest_performance_lounges\/{quest_performance_lounge}",
            "methods": ["PUT", "PATCH"],
            "bindings": {"quest": "id"}
        },
        "quests.quest_performance_lounges.destroy": {
            "uri": "quests\/{quest}\/quest_performance_lounges\/{quest_performance_lounge}",
            "methods": ["DELETE"],
            "bindings": {"quest": "id"}
        },
        "orders-stats": {"uri": "orders-stats", "methods": ["GET", "HEAD"]},
        "certificate-instances.upload": {"uri": "certificate-instances\/upload", "methods": ["POST"]},
        "users.index": {"uri": "users", "methods": ["GET", "HEAD"]},
        "users.create": {"uri": "users\/create", "methods": ["GET", "HEAD"]},
        "users.store": {"uri": "users", "methods": ["POST"]},
        "users.show": {"uri": "users\/{user}", "methods": ["GET", "HEAD"], "bindings": {"user": "id"}},
        "users.edit": {"uri": "users\/{user}\/edit", "methods": ["GET", "HEAD"]},
        "users.update": {"uri": "users\/{user}", "methods": ["PUT", "PATCH"], "bindings": {"user": "id"}},
        "users.destroy": {"uri": "users\/{user}", "methods": ["DELETE"]},
        "users.destroy-many": {"uri": "users\/delete_many", "methods": ["POST"]},
        "news.index": {"uri": "news", "methods": ["GET", "HEAD"]},
        "news.create": {"uri": "news\/create", "methods": ["GET", "HEAD"]},
        "news.store": {"uri": "news", "methods": ["POST"]},
        "news.show": {"uri": "news\/{news}", "methods": ["GET", "HEAD"], "bindings": {"news": "id"}},
        "news.edit": {"uri": "news\/{news}\/edit", "methods": ["GET", "HEAD"]},
        "news.update": {"uri": "news\/{news}", "methods": ["PUT", "PATCH"], "bindings": {"news": "id"}},
        "news.destroy": {"uri": "news\/{news}", "methods": ["DELETE"]},
        "news.destroy-many": {"uri": "news\/delete_many", "methods": ["POST"]},
        "modals.main": {"uri": "modals\/main", "methods": ["GET", "HEAD"]},
        "modals.update-advert-modal": {"uri": "modals\/update_advert_modal", "methods": ["PATCH"]},
        "settings.index": {"uri": "settings", "methods": ["GET", "HEAD"]},
        "orders.view-logs": {
            "uri": "orders\/{order}\/view_logs",
            "methods": ["GET", "HEAD"],
            "bindings": {"order": "id"}
        },
        "orders.change-status": {
            "uri": "orders\/{order}\/change-order-status",
            "methods": ["POST"],
            "bindings": {"order": "id"}
        },
        "orders.payments.index": {
            "uri": "orders\/{order}\/payments",
            "methods": ["GET", "HEAD"],
            "bindings": {"order": "id"}
        },
        "orders.payments.create": {
            "uri": "orders\/{order}\/payments\/create",
            "methods": ["GET", "HEAD"],
            "bindings": {"order": "id"}
        },
        "orders.payments.store": {
            "uri": "orders\/{order}\/payments\/store",
            "methods": ["POST"],
            "bindings": {"order": "id"}
        },
        "orders.payments.register": {"uri": "orders\/{order_payment}\/register", "methods": ["POST"]},
        "orders.payments.refund": {"uri": "orders\/{order_payment}\/refund", "methods": ["POST"]},
        "order-paid": {"uri": "order_paid", "methods": ["GET", "HEAD"]},
        "quests.get-quest-meta": {
            "uri": "quests\/{quest}\/get_quest_meta",
            "methods": ["GET", "HEAD"],
            "bindings": {"quest": "id"}
        },
        "schedule-items.destroy": {"uri": "schedule-items\/{id}\/destroy", "methods": ["DELETE"]},
        "schedule-items.index": {
            "uri": "schedule-items\/{schedule}",
            "methods": ["GET", "HEAD"],
            "bindings": {"schedule": "id"}
        },
        "schedule-items.store": {
            "uri": "schedule-items\/{schedule}",
            "methods": ["POST"],
            "bindings": {"schedule": "id"}
        },
        "lounge-schedule-items.destroy": {"uri": "lounge-schedule-items\/{id}\/destroy", "methods": ["DELETE"]},
        "lounge-schedule-items.index": {
            "uri": "lounge-schedule-items\/{loungeSchedule}",
            "methods": ["GET", "HEAD"],
            "bindings": {"loungeSchedule": "id"}
        },
        "lounge-schedule-items.store": {
            "uri": "lounge-schedule-items\/{loungeSchedule}",
            "methods": ["POST"],
            "bindings": {"loungeSchedule": "id"}
        },
        "profile.edit": {"uri": "profile", "methods": ["GET", "HEAD"]},
        "profile.update": {"uri": "profile", "methods": ["PATCH"]},
        "profile.destroy": {"uri": "profile", "methods": ["DELETE"]},
        "register": {"uri": "register", "methods": ["GET", "HEAD"]},
        "login": {"uri": "login", "methods": ["GET", "HEAD"]},
        "password.request": {"uri": "forgot-password", "methods": ["GET", "HEAD"]},
        "password.email": {"uri": "forgot-password", "methods": ["POST"]},
        "password.reset": {"uri": "reset-password\/{token}", "methods": ["GET", "HEAD"]},
        "password.store": {"uri": "reset-password", "methods": ["POST"]},
        "verification.notice": {"uri": "verify-email", "methods": ["GET", "HEAD"]},
        "verification.verify": {"uri": "verify-email\/{id}\/{hash}", "methods": ["GET", "HEAD"]},
        "verification.send": {"uri": "email\/verification-notification", "methods": ["POST"]},
        "password.confirm": {"uri": "confirm-password", "methods": ["GET", "HEAD"]},
        "password.update": {"uri": "password", "methods": ["PUT"]},
        "logout": {"uri": "logout", "methods": ["POST"]}
    }
};

if (typeof window !== 'undefined' && typeof window.Ziggy !== 'undefined') {
    Object.assign(Ziggy.routes, window.Ziggy.routes);
}

export {Ziggy};
