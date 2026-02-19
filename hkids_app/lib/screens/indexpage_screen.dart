import 'package:flutter/material.dart';

class IndexPage extends StatelessWidget {
  final Map livre; 
  final List pages; 

  const IndexPage({super.key, required this.livre, required this.pages});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFF3F4F6), // bg-gray-100 (py-12)
      appBar: AppBar(
        elevation: 0,
        backgroundColor: Colors.white,
        foregroundColor: Colors.black,
        title: RichText(
          text: TextSpan(
            style: const TextStyle(
              color: Colors.black,
              fontSize: 18,
              fontWeight: FontWeight.w600,
            ),
            children: [
              const TextSpan(text: "Pages du Livre : "),
              TextSpan(
                text: "${livre['titre']}",
                style: const TextStyle(
                  color: Colors.blue,
                  fontWeight: FontWeight.bold,
                ),
              ),
            ],
          ),
        ),
        actions: [
          // Bouton "Ajouter Pages"
          Padding(
            padding: const EdgeInsets.only(right: 8.0),
            child: TextButton.icon(
              onPressed: () => print("Naviguer vers create"),
              icon: const Icon(Icons.add, size: 18),
              label: const Text("Ajouter"),
              style: TextButton.styleFrom(
                backgroundColor: Colors.blue,
                foregroundColor: Colors.white,
                shape: RoundedRectangleBorder(
                  borderRadius: BorderRadius.circular(8),
                ),
              ),
            ),
          ),
        ],
      ),
      body: pages.isEmpty ? _buildEmptyState() : _buildList(),
    );
  }

  Widget _buildEmptyState() {
    return const Center(
      child: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          Icon(Icons.library_books, size: 60, color: Colors.grey),
          SizedBox(height: 10),
          Text(
            "Aucune page ajoutée pour ce livre.",
            style: TextStyle(color: Colors.grey),
          ),
        ],
      ),
    );
  }

  Widget _buildList() {
    return ListView.builder(
      padding: const EdgeInsets.all(16),
      itemCount: pages.length,
      itemBuilder: (context, index) {
        final page = pages[index];

        return Container(
          margin: const EdgeInsets.only(bottom: 12),
          decoration: BoxDecoration(
            color: Colors.white,
            borderRadius: BorderRadius.circular(12),
            border: Border.all(color: Colors.grey.shade200),
          ),
          child: InkWell(
            onTap: () => print("Show page"),
            child: Padding(
              padding: const EdgeInsets.all(16), // Padding interne du container
              child: Row(
                crossAxisAlignment: CrossAxisAlignment.center,
                children: [
                  // 1. Image fixe avec "Object-cover"
                  ClipRRect(
                    borderRadius: BorderRadius.circular(8),
                    child: Image.network(
                      "http://ton-url.com/storage/${page['image']}",
                      width: 64, // w-16
                      height: 64, // h-16
                      fit: BoxFit.cover, // C'est l'équivalent de object-cover
                      errorBuilder: (context, error, stackTrace) => Container(
                        width: 64,
                        height: 64,
                        color: Colors.grey[200],
                        child: Icon(Icons.image),
                      ),
                    ),
                  ),

                  const SizedBox(width: 16), // Espace entre image et texte
                  // 2. Le contenu qui prend tout l'espace (flex-1)
                  Expanded(
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        // Header du contenu (Page + Audio) avec SpaceBetween
                        Row(
                          mainAxisAlignment:
                              MainAxisAlignment.spaceBetween, // justify-between
                          children: [
                            Text(
                              "Page ${page['num_page']}",
                              style: const TextStyle(
                                fontWeight: FontWeight.bold,
                                fontSize: 17,
                                color: Color(0xFF374151),
                              ),
                            ),
                            if (page['audio'] != null)
                              const Text(
                                "🎵 Audio disponible",
                                style: TextStyle(
                                  color: Colors.green,
                                  fontSize: 12,
                                  fontWeight: FontWeight.w500,
                                ),
                              ),
                          ],
                        ),

                        const SizedBox(height: 4),

                        // Texte limité (Str::limit)
                        Text(
                          page['contenu'] ?? "",
                          maxLines: 2,
                          overflow: TextOverflow.ellipsis, // Met les "..."
                          style: TextStyle(
                            color: Colors.grey[600],
                            fontSize: 14,
                            height: 1.4,
                          ),
                        ),
                      ],
                    ),
                  ),
                ],
              ),
            ),
          ),
        );
      },
    );
  }
}
