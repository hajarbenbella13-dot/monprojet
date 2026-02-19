import 'package:flutter/material.dart';

class ShowPageScreen extends StatelessWidget {
  final Map page;
  final Map livre;

  const ShowPageScreen({super.key, required this.page, required this.livre});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFF9FAFB), // gray-50
      appBar: AppBar(
        backgroundColor: Colors.white,
        elevation: 0.5,
        centerTitle: false,
        leading: IconButton(
          icon: const Icon(Icons.arrow_back, color: Colors.black87),
          onPressed: () => Navigator.pop(context),
        ),
        title: RichText(
          text: TextSpan(
            style: const TextStyle(color: Colors.black87, fontSize: 16),
            children: [
              TextSpan(text: "Page ${page['num_page']} du Livre : "),
              TextSpan(
                text: "${livre['titre']}",
                style: const TextStyle(color: Colors.blue, fontWeight: FontWeight.bold),
              ),
            ],
          ),
        ),
      ),
      body: SingleChildScrollView(
        child: Padding(
          padding: const EdgeInsets.symmetric(vertical: 40, horizontal: 16),
          child: Center(
            child: Container(
              // ✅ Hna l-maxWidth bach iji b7al max-w-3xl f Tailwind
              constraints: const BoxConstraints(maxWidth: 600),
              decoration: BoxDecoration(
                color: Colors.white,
                borderRadius: BorderRadius.circular(12),
                boxShadow: [
                  BoxShadow(
                    color: Colors.black.withOpacity(0.05),
                    blurRadius: 10,
                    offset: const Offset(0, 4),
                  )
                ],
              ),
              padding: const EdgeInsets.all(24),
              child: Column(
                mainAxisSize: MainAxisSize.min,
                children: [
                  // --- 1. IMAGE (B7al Blade w-80 h-80) ---
                  if (page['image'] != null)
                    Container(
                      margin: const EdgeInsets.only(bottom: 24),
                      child: ClipRRect(
                        borderRadius: BorderRadius.circular(8),
                        child: Image.network(
                          "http://votre-api.com/storage/${page['image']}",
                          width: 320, // 80 * 4 f tailwind
                          height: 320,
                          fit: BoxFit.cover,
                          errorBuilder: (context, error, stackTrace) =>
                              Container(
                                width: 320,
                                height: 320,
                                color: Colors.grey[100],
                                child: const Icon(Icons.image, size: 50, color: Colors.grey)
                              ),
                        ),
                      ),
                    ),

                  // --- 2. AUDIO (UI Simulé) ---
                  if (page['audio'] != null)
                    Container(
                      margin: const EdgeInsets.only(bottom: 24),
                      padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 8),
                      decoration: BoxDecoration(
                        color: Colors.grey[50],
                        borderRadius: BorderRadius.circular(50),
                        border: Border.all(color: Colors.black12),
                      ),
                      child: Row(
                        children: [
                          const Icon(Icons.play_arrow_rounded, size: 32, color: Colors.blue),
                          Expanded(
                            child: Slider(
                              value: 0.2,
                              onChanged: (v) {},
                              activeColor: Colors.blue,
                              inactiveColor: Colors.blue.withOpacity(0.1),
                            ),
                          ),
                          const Text("0:15 / 1:30", style: TextStyle(fontSize: 11, color: Colors.grey)),
                        ],
                      ),
                    ),

                  // --- 3. CONTENU (Texte) ---
                  Text(
                    page['contenu'] ?? "",
                    textAlign: TextAlign.center,
                    style: const TextStyle(
                      fontSize: 20,
                      fontWeight: FontWeight.w600,
                      color: Color(0xFF1F2937), // gray-800
                      height: 1.6,
                    ),
                  ),

                  const SizedBox(height: 32),

                  // --- 4. BUTTONS (Modifier / Supprimer) ---
                  const Divider(height: 1, color: Color(0xFFF3F4F6)),
                  const SizedBox(height: 24),
                  Wrap(
                    spacing: 12,
                    runSpacing: 12,
                    alignment: WrapAlignment.center,
                    children: [
                      _buildActionButton(
                        label: "Modifier",
                        icon: Icons.edit_outlined,
                        color: Colors.amber[500]!,
                        onTap: () {},
                      ),
                      _buildActionButton(
                        label: "Supprimer",
                        icon: Icons.delete_outline,
                        color: Colors.red[600]!,
                        onTap: () => _showDeleteDialog(context),
                      ),
                    ],
                  ),
                ],
              ),
            ),
          ),
        ),
      ),
    );
  }

  // --- UI Helper: Action Button ---
  Widget _buildActionButton({
    required String label,
    required IconData icon,
    required Color color,
    required VoidCallback onTap,
  }) {
    return ElevatedButton.icon(
      onPressed: onTap,
      icon: Icon(icon, size: 18, color: Colors.white),
      label: Text(label, style: const TextStyle(color: Colors.white, fontWeight: FontWeight.bold)),
      style: ElevatedButton.styleFrom(
        backgroundColor: color,
        elevation: 0,
        padding: const EdgeInsets.symmetric(horizontal: 24, vertical: 14),
        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(8)),
      ),
    );
  }

  // --- UI Helper: Delete Confirm ---
  void _showDeleteDialog(BuildContext context) {
    showDialog(
      context: context,
      builder: (context) => AlertDialog(
        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
        title: const Text("Supprimer cette page ?"),
        content: const Text("Voulez-vous vraiment supprimer cette page ? Cette action est irréversible."),
        actions: [
          TextButton(
            onPressed: () => Navigator.pop(context),
            child: const Text("Annuler", style: TextStyle(color: Colors.grey)),
          ),
          TextButton(
            onPressed: () => Navigator.pop(context),
            child: const Text("Supprimer", style: TextStyle(color: Colors.red, fontWeight: FontWeight.bold)),
          ),
        ],
      ),
    );
  }
}