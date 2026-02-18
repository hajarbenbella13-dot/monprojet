import 'package:flutter/material.dart';
import 'ajouterlivre_screen.dart';
import 'livreslist_screen.dart';

class DashboardScreen extends StatefulWidget {
  @override
  _DashboardScreenState createState() => _DashboardScreenState();
}

class _DashboardScreenState extends State<DashboardScreen> {
  bool showAllLecteurs = false;

  // Data mock (Simulant les variables $stats et $popular_livres)
  final Map<String, dynamic> stats = {
    'total_lecteurs': 124,
    'total_livres': 45,
    'total_pages': 1250,
    'livres_vides': 3,
    'recent_lecteurs': [
      {'id': 1, 'nom': 'Ahmed Alami', 'age': 24},
      {'id': 2, 'nom': 'Sara Bennani', 'age': 21},
      {'id': 3, 'nom': 'Omar Tazi', 'age': 28},
      {'id': 4, 'nom': 'Yassine Fahmi', 'age': 25},
    ],
  };

  final List<Map<String, dynamic>> popularLivres = [
    {'titre': 'L\'Art de la Guerre', 'progressions_count': 85},
    {'titre': 'Flutter Pro Tips', 'progressions_count': 60},
    {'titre': 'Laravel Mastery', 'progressions_count': 45},
  ];

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Color(0xFFF9FAFB), // gray-50
      body: SafeArea(
        child: SingleChildScrollView(
          padding: EdgeInsets.symmetric(horizontal: 20, vertical: 24),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              // --- HEADER SECTION ---
              _buildHeader(),
              SizedBox(height: 32),

              // --- ALERT SECTION (Livres Vides) ---
              if (stats['livres_vides'] > 0) _buildAlert(),

              // --- STATS CARDS GRID ---
              LayoutBuilder(
                builder: (context, constraints) {
                  return GridView.count(
                    shrinkWrap: true,
                    physics: NeverScrollableScrollPhysics(),
                    crossAxisCount: constraints.maxWidth > 600 ? 3 : 1,
                    childAspectRatio: 2.5,
                    crossAxisSpacing: 16,
                    mainAxisSpacing: 16,
                    children: [
                      _buildStatCard(
                        "Lecteurs Total",
                        "${stats['total_lecteurs']}",
                        "👥",
                        Colors.blue[50]!,
                      ),
                      _buildStatCard(
                        "Livres",
                        "${stats['total_livres']}",
                        "📖",
                        Colors.green[50]!,
                      ),
                      _buildStatCard(
                        "Total Pages",
                        "${stats['total_pages']}",
                        "📄",
                        Colors.purple[50]!,
                      ),
                    ],
                  );
                },
              ),
              SizedBox(height: 32),

              // --- MAIN CONTENT GRID (Lecteurs & Populaires) ---
              LayoutBuilder(
                builder: (context, constraints) {
                  bool isDesktop = constraints.maxWidth > 900;
                  return Flex(
                    direction: isDesktop ? Axis.horizontal : Axis.vertical,
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Expanded(
                        flex: isDesktop ? 1 : 0,
                        child: _buildLecteursSection(),
                      ),
                      if (isDesktop) SizedBox(width: 24),
                      if (!isDesktop) SizedBox(height: 24),
                      Expanded(
                        flex: isDesktop ? 1 : 0,
                        child: _buildPopularSection(),
                      ),
                    ],
                  );
                },
              ),
            ],
          ),
        ),
      ),
    );
  }

  // --- WIDGET COMPONENTS ---

  Widget _buildHeader() {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Row(
          mainAxisAlignment: MainAxisAlignment.spaceBetween,
          children: [
            Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Row(
                  children: [
                    Text("📊", style: TextStyle(fontSize: 32)),
                    SizedBox(width: 12),
                    Text(
                      "Tableau de Bord",
                      style: TextStyle(
                        fontSize: 28,
                        fontWeight: FontWeight.w900,
                        color: Color(0xFF1F2937),
                      ),
                    ),
                  ],
                ),
                Text(
                  "Gérez votre bibliothèque et suivez l'activité.",
                  style: TextStyle(
                    color: Colors.grey[500],
                    fontSize: 14,
                    fontWeight: FontWeight.w500,
                  ),
                ),
              ],
            ),
          ],
        ),
        SizedBox(height: 20),
        Wrap(
          spacing: 12,
          runSpacing: 12,
          children: [
            GestureDetector(
              onTap: () {
                Navigator.push(
                  context,
                  MaterialPageRoute(
                    builder: (context) => const AjouterLivreScreen(),
                  ),
                );
              },
              child: _buildActionButton(
                "➕ NOUVEAU LIVRE",
                Colors.white,
                const Color(0xFF1F2937),
                true,
              ),
            ),
            GestureDetector(
              onTap: () {
                Navigator.push(
                  context,
                  MaterialPageRoute(
                    builder: (context) => const LivresListScreen(),
                  ),
                );
              },
              child: _buildActionButton(
                "📚 BIBLIOTHÈQUE",
                const Color(0xFF4F46E5),
                Colors.white,
                false,
              ),
            ),
          ],
        ),
      ],
    );
  }

  Widget _buildActionButton(
    String text,
    Color bg,
    Color textColor,
    bool border,
  ) {
    return Container(
      padding: EdgeInsets.symmetric(horizontal: 20, vertical: 12),
      decoration: BoxDecoration(
        color: bg,
        borderRadius: BorderRadius.circular(16),
        border: border ? Border.all(color: Colors.grey[200]!) : null,
        boxShadow: [
          BoxShadow(color: Colors.black.withOpacity(0.05), blurRadius: 10),
        ],
      ),
      child: Text(
        text,
        style: TextStyle(
          color: textColor,
          fontWeight: FontWeight.w900,
          fontSize: 12,
        ),
      ),
    );
  }

  Widget _buildAlert() {
    return Container(
      margin: EdgeInsets.only(bottom: 24),
      padding: EdgeInsets.all(16),
      decoration: BoxDecoration(
        color: Color(0xFFFFFBEB),
        border: Border(left: BorderSide(color: Colors.amber, width: 4)),
        borderRadius: BorderRadius.only(
          topRight: Radius.circular(16),
          bottomRight: Radius.circular(16),
        ),
      ),
      child: Row(
        children: [
          Text("⚠️", style: TextStyle(fontSize: 20)),
          SizedBox(width: 12),
          Text(
            "Attention: ${stats['livres_vides']} livre(s) n'ont pas de pages.",
            style: TextStyle(
              color: Color(0xFF92400E),
              fontWeight: FontWeight.w500,
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildStatCard(
    String title,
    String value,
    String emoji,
    Color iconBg,
  ) {
    return Container(
      padding: EdgeInsets.all(20),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(24),
        border: Border.all(color: Color(0xFFF3F4F6)),
      ),
      child: Row(
        children: [
          Container(
            padding: EdgeInsets.all(12),
            decoration: BoxDecoration(
              color: iconBg,
              borderRadius: BorderRadius.circular(16),
            ),
            child: Text(emoji, style: TextStyle(fontSize: 24)),
          ),
          SizedBox(width: 16),
          Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              Text(
                title.toUpperCase(),
                style: TextStyle(
                  color: Colors.grey,
                  fontSize: 10,
                  fontWeight: FontWeight.w900,
                  letterSpacing: 1,
                ),
              ),
              Text(
                value,
                style: TextStyle(
                  fontSize: 24,
                  fontWeight: FontWeight.w900,
                  color: Color(0xFF1F2937),
                ),
              ),
            ],
          ),
        ],
      ),
    );
  }

  Widget _buildLecteursSection() {
    var list = stats['recent_lecteurs'];
    int displayCount = showAllLecteurs ? list.length : 3;

    return Container(
      padding: EdgeInsets.all(24),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(24),
        border: Border.all(color: Color(0xFFF3F4F6)),
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Text(
            "Les Lecteurs",
            style: TextStyle(fontSize: 20, fontWeight: FontWeight.w900),
          ),
          SizedBox(height: 20),
          for (int i = 0; i < displayCount && i < list.length; i++)
            _buildLecteurItem(list[i]['nom'], "${list[i]['age']} ANS"),
          if (list.length > 3)
            Center(
              child: TextButton(
                onPressed: () =>
                    setState(() => showAllLecteurs = !showAllLecteurs),
                child: Text(
                  showAllLecteurs ? "↑ RÉDUIRE" : "↓ VOIR TOUT",
                  style: TextStyle(
                    color: Colors.grey,
                    fontWeight: FontWeight.w900,
                    fontSize: 12,
                  ),
                ),
              ),
            ),
        ],
      ),
    );
  }

  Widget _buildLecteurItem(String name, String age) {
    return Container(
      margin: EdgeInsets.only(bottom: 12),
      padding: EdgeInsets.all(16),
      decoration: BoxDecoration(
        color: Color(0xFFF9FAFB),
        borderRadius: BorderRadius.circular(16),
      ),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: [
          Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Text(
                name.toUpperCase(),
                style: TextStyle(
                  fontWeight: FontWeight.bold,
                  color: Color(0xFF374151),
                ),
              ),
              Text(age, style: TextStyle(fontSize: 10, color: Colors.grey)),
            ],
          ),
          Container(
            padding: EdgeInsets.symmetric(horizontal: 12, vertical: 6),
            decoration: BoxDecoration(
              color: Colors.white,
              border: Border.all(color: Color(0xFFE0E7FF)),
              borderRadius: BorderRadius.circular(10),
            ),
            child: Text(
              "PROFIL →",
              style: TextStyle(
                color: Color(0xFF4F46E5),
                fontSize: 10,
                fontWeight: FontWeight.w900,
              ),
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildPopularSection() {
    return Container(
      padding: EdgeInsets.all(24),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(24),
        border: Border.all(color: Color(0xFFF3F4F6)),
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Text(
            "🔥 Livres les plus lus",
            style: TextStyle(fontSize: 20, fontWeight: FontWeight.w900),
          ),
          SizedBox(height: 24),
          ...popularLivres
              .map(
                (livre) => _buildProgressBar(
                  livre['titre'],
                  livre['progressions_count'],
                ),
              )
              .toList(),
        ],
      ),
    );
  }

  Widget _buildProgressBar(String title, int count) {
    double progress = count / stats['total_lecteurs'];
    return Padding(
      padding: const EdgeInsets.only(bottom: 20),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Row(
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            children: [
              Text(
                title,
                style: TextStyle(
                  fontWeight: FontWeight.bold,
                  color: Color(0xFF374151),
                ),
              ),
              Container(
                padding: EdgeInsets.symmetric(horizontal: 8, vertical: 4),
                decoration: BoxDecoration(
                  color: Color(0xFFFEF3C7),
                  borderRadius: BorderRadius.circular(8),
                ),
                child: Text(
                  "$count LECTURES",
                  style: TextStyle(
                    color: Color(0xFFB45309),
                    fontSize: 10,
                    fontWeight: FontWeight.w900,
                  ),
                ),
              ),
            ],
          ),
          SizedBox(height: 8),
          ClipRRect(
            borderRadius: BorderRadius.circular(10),
            child: LinearProgressIndicator(
              value: progress,
              backgroundColor: Color(0xFFF3F4F6),
              color: Colors.amber[500],
              minHeight: 10,
            ),
          ),
        ],
      ),
    );
  }
}
